<?php

/**
 * Template for how the tabbed content on the home page should look
 * This should be transformed into a WP Block with each bubble having:
 * Title, Icon, Content, Colour
 */
$items = array(
    1 => ['title' => 'Economic Stability', 'content' => 'We help single women access essential resources like financial support, safe housing, and jobs that pay a living wage.
Our goal is to make security and stability available to everyone in our community.'],
    2 => ['title' => 'Total Wellbeing', 'content' => 'We promote the experience of health and happiness, fulfillment, social connection, engagement, and a sense of purpose.
We believe that a healthy balance of self-love, social connections, and engagement with your surroundings is key to total wellbeing.'],
    3 => ['title' => 'Community Integration', 'content' => 'With the assistance of our programs, we aid in integrating our members into the community through social connections, access and utilization of supportive resources, recreational events and activities, development of living skills, and educational and training opportunities.'],
    4 => ['title' => 'Opportunity', 'content' => 'We are a completely volunteer-run non profit organization, and we are always eager to meet new individuals who have an interest in offering their time, energy, and experience to Single Women in Motherhood.'],
);
?>
<div class="mission-statements swim-tabbed-list-container swim-bubble-list">
    <?php foreach ($items as $key => $item) : ?>
        <section class="swim-bubble-row item-<?= esc_attr($key); ?><?= $key % 2 === 1 ? ' bubble-left' : ' bubble-right'; ?>">
            <div class="swim-bubble-pill">
                <div class="item-content"><?= nl2br(esc_html($item['content'])); ?></div>
            </div>
            <div class="swim-bubble-circle">
                <h3 class="item-title"><?= esc_html($item['title']); ?></h3>
            </div>
        </section>
    <?php endforeach; ?>
</div>
