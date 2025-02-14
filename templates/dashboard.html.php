<?php

/**
 * @var \DateTimeInterface $date_start
 * @var \DateTimeInterface $date_end
 * @var string $date_range
 * @var string[] $date_ranges
 * @var \App\Entity\SiteStats $totals
 * @var \App\Entity\SiteStats $totals_previous
 * @var \App\Entity\PageStats[] $pages
 * @var \App\Entity\ReferrerStats[] $referrers
 * @var \App\Chart $chart
 * @var int $realtime_count
 */

$title = 'Koko Analytics';
require __DIR__ . '/_header.html.php'; ?>

<?php /* Datepicker */ ?>
<details class="datepicker">
    <summary><?= esc($date_start->format('M j, Y')); ?> &mdash; <?= esc($date_end->format('M j, Y')); ?></summary>
    <div class="datepicker-dropdown">
        <div class="datepicker-title">
        <?= esc($date_start->format('M j, Y')); ?> &mdash; <?= esc($date_end->format('M j, Y')); ?>
        </div>
        <div class="datepicker-inner">
            <form>
                <div>
                    <label for="date-range-input">Date range</label>
                    <select name="date-range" id="date-range-input">
                        <option value="custom" <?= $date_range === 'custom' ? 'selected' : ''; ?> disabled>Custom</option>
                        <?php foreach ($date_ranges as $value => $label) : ?>
                            <option value="<?= esc($value); ?>" <?= $date_range === $value ? 'selected' : ''; ?>><?= esc($label); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div style="display: flex; margin-top: 12px;">
                    <div>
                        <label for="date-start-input">Start date</label>
                        <input type="date" name="date-start" id="date-start-input" value="<?= esc($date_start->format('Y-m-d')); ?>" required>
                        &nbsp;&mdash;&nbsp;
                    </div>

                    <div>
                        <label for="date-end-input">End date</label>
                        <input type="date" name="date-end" id="date-end-input" value="<?= esc($date_end->format('Y-m-d')); ?>" required>
                    </div>
                </div>
                <div>
                    <button type="submit">View</button>
                </div>
            </form>
        </div>
    </div>
</details>


<?php
/* Site wide totals */
$visitors_change = $totals_previous->visitors == 0 ? 0 : ($totals->visitors / $totals_previous->visitors) - 1;
$pageviews_change = $totals_previous->pageviews == 0 ? 0 : ($totals->pageviews / $totals_previous->pageviews) - 1;
?>
<table class="totals">
    <tbody>

    <tr>
        <th>Total visitors</th>
        <td class="totals-amount">
            <?= number_format($totals->visitors); ?>
            <span class="totals-change <?= $visitors_change > 0 ? 'up' : 'down'; ?>">
                <?= percent_format($visitors_change); ?>
            </span>
        </td>
        <td class="totals-subtext">
            <?= number_format(abs($totals->visitors - $totals_previous->visitors)); ?>
            <?= $totals->visitors > $totals_previous->visitors ? 'more' : 'less'; ?>
            than in previous period
        </td>
    </tr>
    <tr>
        <th>Total pageviews</th>
        <td class="totals-amount">
            <?= number_format($totals->pageviews); ?>
            <span class="totals-change <?= $pageviews_change > 0 ? 'up' : 'down'; ?>">
                <?= percent_format($pageviews_change); ?>
            </span>
        </td>
        <td class="totals-subtext">
            <?= number_format(abs($totals->pageviews - $totals_previous->pageviews)); ?>
            <?= $totals->pageviews > $totals_previous->pageviews ? 'more' : 'less'; ?>
            than in previous period
        </td>
    </tr>
    <tr>
        <th>Realtime pageviews</th>
        <td class="totals-amount">
            <?= number_format($realtime_count); ?>
        </td>
        <td class="totals-subtext">
            pageviews in the last hour
        </td>
    </tr>
    </tbody>
</table>

<?php /* Chart */ ?>
<div class="box chart">
    <?php $chart->render(); ?>
</div>

<div class="boxes">
    <?php /* Page stats */ ?>
    <div class="box">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Page</th>
                <th>Visitors</th>
                <th>Pageviews</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pages as $rank => $p) : ?>
                <tr>
                    <td><?= $rank + 1; ?></td>
                    <td><a href=""><?= esc($p->url); ?></a></td>
                    <td><?= number_format($p->visitors); ?></td>
                    <td><?= number_format($p->pageviews); ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($pages)) : ?>
                <tr>
                    <td colspan="4">There is nothing here. Yet!</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>

    <?php /* Referrer stats */ ?>
    <div class="box">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Referrer</th>
                <th>Visitors</th>
                <th>Pageviews</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($referrers as $rank => $p) : ?>
                <tr>
                    <td><?= $rank + 1; ?></td>
                    <td><a href="<?= esc($p->url); ?>"><?= get_referrer_url_label(esc($p->url)); ?></a></td>
                    <td><?= number_format($p->visitors); ?></td>
                    <td><?= number_format($p->pageviews); ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($referrers)) : ?>
                <tr>
                    <td colspan="4">There is nothing here. Yet!</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
</div>

<script src="/dashboard.js"></script>

<?php require __DIR__ . '/_footer.html.php'; ?>
