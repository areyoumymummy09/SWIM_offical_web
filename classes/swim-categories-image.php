<?php

if (!defined('ABSPATH'))
    die;

class SWIMCategoriesImages {
    public $plugin_name;
    private $SWIMci_placeholder;

    function __construct() {
        $this->plugin_name = plugin_basename(__FILE__);

        // The placeholder image url
        $this->SWIMci_placeholder = plugins_url('/assets/images/placeholder.png', __FILE__);
        add_action('admin_init', [$this, 'SWIMAdminInit']);

        // save our taxonomy image while edit or create term
        add_action('edit_term', [$this, 'SWIMSaveTaxonomyImage']);
        add_action('create_term', [$this, 'SWIMSaveTaxonomyImage']);

        // Plugin menu in admin panel
        add_action('admin_menu', [$this, 'SWIMSettingsMenu']);

        // Settings page link in plugins list
        add_filter("plugin_action_links_{$this->plugin_name}", [$this, 'SWIMSettingsLink']);
    }

    function SWIMAdminInit() {
        $SWIM_taxonomies = get_taxonomies();
        if (is_array($SWIM_taxonomies)) {
            $SWIMci_options = get_option('SWIMci_options');

            if (!is_array($SWIMci_options))
                $SWIMci_options = array();

            if (empty($SWIMci_options['excluded_taxonomies']))
                $SWIMci_options['excluded_taxonomies'] = array();

            foreach ($SWIM_taxonomies as $SWIM_taxonomy) {
                if (in_array($SWIM_taxonomy, $SWIMci_options['excluded_taxonomies']))
                    continue;
                add_action($SWIM_taxonomy . '_add_form_fields', [$this, 'SWIMAddTexonomyField']);
                add_action($SWIM_taxonomy . '_edit_form_fields', [$this, 'SWIMEditTexonomyField']);
                add_filter('manage_edit-' . $SWIM_taxonomy . '_columns', [$this, 'SWIMTaxonomyColumns']);
                add_filter('manage_' . $SWIM_taxonomy . '_custom_column', [$this, 'SWIMTaxonomyColumn'], 10, 3);

                // If tax is deleted
                add_action("delete_{$SWIM_taxonomy}", function ($tt_id) {
                    delete_option('SWIM_taxonomy_image' . $tt_id);
                });
            }
        }

        // Register styles and scripts
        if (strpos($_SERVER['SCRIPT_NAME'], 'edit-tags.php') > 0 || strpos($_SERVER['SCRIPT_NAME'], 'term.php') > 0) {
            add_action('admin_enqueue_scripts', [$this, 'SWIMAdminEnqueue']);
            add_action('quick_edit_custom_box', [$this, 'SWIMQuickEditCustomBox'], 10, 3);
        }

        // Register settings
        register_setting('SWIMci_options', 'SWIMci_options');
        add_settings_section('SWIMci_settings', __('Categories Images settings', 'categories-images'), [$this, 'SWIMSectionText'], 'SWIMci-options');
        add_settings_field('SWIM_excluded_taxonomies', __('Excluded Taxonomies', 'categories-images'), [$this, 'SWIMExcludedTaxonomies'], 'SWIMci-options', 'SWIMci_settings');
    }

    function SWIMAdminEnqueue() {
        // wp_enqueue_style('categories-images-styles', plugins_url('/assets/css/SWIMci-styles.css', __FILE__));
        wp_enqueue_script('categories-images-scripts', get_template_directory_uri() . '/assets/js/admin/category-images.js');

        $SWIMci_js_config = [
            'wordpress_ver' => get_bloginfo("version"),
            'placeholder' => $this->SWIMci_placeholder
        ];
        wp_localize_script('categories-images-scripts', 'SWIMci_config', $SWIMci_js_config);
    }

    // add image field in add form
    function SWIMAddTexonomyField() {
        if (get_bloginfo('version') >= 3.5)
            wp_enqueue_media();
        else {
            wp_enqueue_style('thickbox');
            wp_enqueue_script('thickbox');
        }

        echo '<div class="form-field">
            <label for="SWIMci_taxonomy_image">' . __('Image', 'categories-images') . '</label>
            <input type="text" name="SWIMci_taxonomy_image" id="SWIMci_taxonomy_image" value="" />
            <br/>
            <button class="SWIM_upload_image_button button">' . __('Upload/Add image', 'categories-images') . '</button>
        </div>';
    }

    // add image field in edit form
    function SWIMEditTexonomyField($taxonomy) {
        if (get_bloginfo('version') >= 3.5)
            wp_enqueue_media();
        else {
            wp_enqueue_style('thickbox');
            wp_enqueue_script('thickbox');
        }

        if ($this->SWIMTaxonomyImageUrl($taxonomy->term_id, NULL, TRUE) == $this->SWIMci_placeholder)
            $image_url = "";
        else
            $image_url = $this->SWIMTaxonomyImageUrl($taxonomy->term_id, NULL, TRUE);
        echo '<tr class="form-field">
            <th scope="row" valign="top"><label for="SWIMci_taxonomy_image">' . __('Image', 'categories-images') . '</label></th>
            <td><img class="SWIMci-taxonomy-image" src="' . $this->SWIMTaxonomyImageUrl($taxonomy->term_id, 'medium', TRUE) . '"/><br/><input type="text" name="SWIMci_taxonomy_image" id="SWIMci_taxonomy_image" value="' . $image_url . '" /><br />
            <button class="SWIM_upload_image_button button">' . __('Upload/Add image', 'categories-images') . '</button>
            <button class="SWIM_remove_image_button button">' . __('Remove image', 'categories-images') . '</button>
            </td>
        </tr>';
    }

    /**
     * Thumbnail column added to category admin.
     *
     * @access public
     * @param mixed $columns
     * @return void
     */
    function SWIMTaxonomyColumns($columns) {
        $new_columns = array();
        $new_columns['cb'] = $columns['cb'];
        $new_columns['thumb'] = __('Image', 'categories-images');

        unset($columns['cb']);

        return array_merge($new_columns, $columns);
    }

    /**
     * Thumbnail column value added to category admin.
     *
     * @access public
     * @param mixed $columns
     * @param mixed $column
     * @param mixed $id
     * @return void
     */
    function SWIMTaxonomyColumn($columns, $column, $id) {
        if ($column == 'thumb')
            $columns = '<span><img src="' . $this->SWIMTaxonomyImageUrl($id, 'thumbnail', TRUE) . '" alt="' . __('Thumbnail', 'categories-images') . '" class="wp-post-image" /></span>';

        return $columns;
    }

    function SWIMQuickEditCustomBox($column_name, $screen, $name) {
        if ($column_name == 'thumb')
            echo '<fieldset>
            <div class="thumb inline-edit-col">
                <label>
                    <span class="title"><img src="" alt="Thumbnail"/></span>
                    <span class="input-text-wrap"><input type="text" name="SWIMci_taxonomy_image" value="" class="tax_list" /></span>
                    <span class="input-text-wrap">
                        <button class="SWIM_upload_image_button button">' . __('Upload/Add image', 'categories-images') . '</button>
                        <button class="SWIM_remove_image_button button">' . __('Remove image', 'categories-images') . '</button>
                    </span>
                </label>
            </div>
        </fieldset>';
    }

    function SWIMSaveTaxonomyImage($term_id) {
        if (isset($_POST['SWIMci_taxonomy_image'])) {
            update_option('SWIM_taxonomy_image' . $term_id, $_POST['SWIMci_taxonomy_image'], false);
        }
    }

    // get attachment ID by image url
    function SWIMGetAttachmentIdByUrl($image_src) {
        global $wpdb;
        $query = $wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid = %s", $image_src);
        $id = $wpdb->get_var($query);
        return (!empty($id)) ? $id : NULL;
    }

    // get taxonomy image url for the given term_id (Place holder image by default)
    function SWIMTaxonomyImageUrl($term_id = NULL, $size = 'full', $return_placeholder = FALSE) {
        if (!$term_id) {
            if (is_category())
                $term_id = get_query_var('cat');
            elseif (is_tag())
                $term_id = get_query_var('tag_id');
            elseif (is_tax()) {
                $current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
                $term_id = $current_term->term_id;
            }
        }

        $taxonomy_image_url = get_option('SWIM_taxonomy_image' . $term_id);
        if (!empty($taxonomy_image_url)) {
            $attachment_id = $this->SWIMGetAttachmentIdByUrl($taxonomy_image_url);
            if (!empty($attachment_id)) {
                $taxonomy_image_url = wp_get_attachment_image_src($attachment_id, $size);
                $taxonomy_image_url = $taxonomy_image_url[0];
            }
        }

        if ($return_placeholder)
            return ($taxonomy_image_url != '') ? $taxonomy_image_url : $this->SWIMci_placeholder;
        else
            return $taxonomy_image_url;
    }

    // display taxonomy image for the given term_id
    function SWIMTaxonomyImage($term_id = NULL, $size = 'full', $attr = NULL, $echo = TRUE) {
        if (!$term_id) {
            if (is_category())
                $term_id = get_query_var('cat');
            elseif (is_tag())
                $term_id = get_query_var('tag_id');
            elseif (is_tax()) {
                $current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
                $term_id = $current_term->term_id;
            }
        }

        $taxonomy_image_url = get_option('SWIM_taxonomy_image' . $term_id);
        if (!empty($taxonomy_image_url)) {
            $attachment_id = $this->SWIMGetAttachmentIdByUrl($taxonomy_image_url);
            if (!empty($attachment_id))
                $taxonomy_image = wp_get_attachment_image($attachment_id, $size, FALSE, $attr);
            else {
                $image_attr = '';
                if (is_array($attr)) {
                    if (!empty($attr['class']))
                        $image_attr .= ' class="' . $attr['class'] . '" ';
                    if (!empty($attr['alt']))
                        $image_attr .= ' alt="' . $attr['alt'] . '" ';
                    if (!empty($attr['width']))
                        $image_attr .= ' width="' . $attr['width'] . '" ';
                    if (!empty($attr['height']))
                        $image_attr .= ' height="' . $attr['height'] . '" ';
                    if (!empty($attr['title']))
                        $image_attr .= ' title="' . $attr['title'] . '" ';
                }
                $taxonomy_image = '<img src="' . $taxonomy_image_url . '" ' . $image_attr . '/>';
            }
        } else {
            $taxonomy_image = '';
        }

        if ($echo)
            echo $taxonomy_image;
        else
            return $taxonomy_image;
    }

    function SWIMSettingsMenu() {
        add_menu_page(__('Categories Images settings', 'categories-images'), __('Categories Images', 'categories-images'), 'manage_options', 'SWIMci_settings', [$this, 'SWIMSettingsPage'], 'dashicons-format-image', 80);
    }

    // Plugin option page
    function SWIMSettingsPage() {
        if (!current_user_can('manage_options'))
            wp_die(__('You do not have sufficient permissions to access this page.', 'categories-images'));
        require_once plugin_dir_path(__FILE__) . 'templates/admin.php';
    }

    function SWIMSettingsLink($links) {
        $settings_link = '<a href="admin.php?page=SWIMci_settings">Settings</a>';
        array_push($links, $settings_link);
        return $links;
    }

    // Settings section description
    function SWIMSectionText() {
        echo '<p>' . __('Please select the taxonomies you want to exclude it from Categories Images plugin', 'categories-images') . '</p>';
    }

    // Excluded taxonomies checkboxs
    function SWIMExcludedTaxonomies() {
        $options = get_option('SWIMci_options');
        $disabled_taxonomies = ['nav_menu', 'link_category', 'post_format'];
        foreach (get_taxonomies() as $tax) : if (in_array($tax, $disabled_taxonomies)) continue; ?>
            <input type="checkbox" name="SWIMci_options[excluded_taxonomies][<?php echo $tax ?>]" value="<?php echo $tax ?>" <?php checked(isset($options['excluded_taxonomies'][$tax])); ?> /> <?php echo $tax; ?><br />
<?php endforeach;
    }

    function activate() {
        // Things will happen if the plugin activated.
        flush_rewrite_rules();
    }

    function deactivate() {
        // Things will happen if the plugin deactivated.
        flush_rewrite_rules();
    }
}

if (class_exists('SWIMCategoriesImages')) {
    function SWIM_taxonomy_image_url($term_id = NULL, $size = 'full', $return_placeholder = FALSE) {
        $SWIMci = new SWIMCategoriesImages();
        return $SWIMci->SWIMTaxonomyImageUrl($term_id, $size, $return_placeholder);
    }

    function SWIM_taxonomy_image($term_id = NULL, $size = 'full', $attr = NULL, $echo = TRUE) {
        $SWIMci = new SWIMCategoriesImages();
        return $SWIMci->SWIMTaxonomyImage($term_id, $size, $attr, $echo);
    }
}
