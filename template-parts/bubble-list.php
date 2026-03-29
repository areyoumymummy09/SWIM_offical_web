<?php

/**
 * Template for how the tabbed content on the home page should look
 * This should be transformed into a WP Block with each bubble having:
 * Title, Icon, Content, Colour
 */
$items = array(
    1 => ['icon' => 'fas fa-award', 'title' => 'Economic Stability', 'content' => 'We strive to provide single women the ability to access the resources that are essential to life in today’s society. We know the importance of financial resources, stable and safe housing, and career opportunities that can offer a living wage. We intend to ensure that our community will have ease of access to necessary resources to make overall security a reality.'],
    2 => ['icon' => 'fas fa-spa', 'title' => 'Total Wellbeing', 'content' => 'We promote the experience of health and happiness, fulfillment, social connection, engagement, and a sense of purpose. We believe that a healthy balance of self-love, social connections, and engagement with your surroundings is key to total wellbeing'],
    3 => ['icon' => 'fas fa-users', 'title' => 'Community Integration', 'content' => 'With the assistance of our programs, we aid in integrating our members into the community through social connections, access and utilization of supportive resources, recreational events and activities, development of living skills, and educational and training opportunities'],
    4 => ['icon' => 'fas fa-bullhorn', 'title' => 'Opportunity', 'content' => 'We are a completely volunteer-run non profit organization, and we are always eager to meet new individuals who have an interest in offering their time, energy, and experience to Single Women in Motherhood']
);
?>
<div class="mission-statements swim-tabbed-list-container">
    <ul class="swim-tabbed-list" data-active-collapse="true" data-tabs id="bubble-tabs">
        <?php foreach ($items as $key => $item) : ?>
            <li class="swim-list-item tabs-title item-<?= esc_html($key); ?>">
                <a class="item-container" href="#panel<?= esc_html($key); ?>">
                    <span class="item-icon <?= esc_html($item['icon']); ?>"></span>
                    <h4 class="item-title"><?= esc_html__($item['title']); ?></h4>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="swim-tabbed-list-content" data-tabs-content="bubble-tabs">
        <?php foreach ($items as $key => $item) : ?>
            <div id="panel<?= esc_html($key); ?>" class="swim-list-item-panel item-<?= esc_html($key); ?>">
                <h4 class="item-title"><?= esc_html__($item['title'] . " "); ?><span class="item-icon <?= esc_html($item['icon']); ?>"></span></h4>
                <div class="item-content"><?= esc_html($item['content']) ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>