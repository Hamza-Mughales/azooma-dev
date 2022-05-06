<link href="<?= base_url(css_path()) ?>/datatable/datatable.css" rel="stylesheet">

<div class="pt-2">
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo base_url(); ?>"><?= lang('Dashboard') ?></a> <span class="divider">/</span>
        </li>
 
        <li class="active"><?= lang('ratings') ?> </li>
    </ul>
</div>
<div class="card">
<div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordernone" id="basic-1">
              <thead class="text-center">
                <tr>

                  <th scope="col"><?= lang('id') ?></th>
                  <th><?= lang('user_name') ?></th>
                  <th scope="col"><?= lang('Food') ?></th>
                  <th scope="col"><?= lang('Service') ?></th>
                  <th scope="col"><?= lang('Atmosphere') ?></th>
                  <th scope="col"><?= lang('Value') ?></th>
                  <th scope="col"><?= lang('Presentation') ?></th>
                  <th scope="col"><?= lang('Variety') ?></th>
                  <th width="15%" scope="col"><?= lang('Total') ?></th>
                </tr>
              </thead>
              <tbody class="text-center">
                <?php if (isset($rates) and !empty($rates)) { ?>
                  <?php
                  $i = 0;

                  foreach ($rates as $p) {
                    $total = 0;
                    $i++;
                  ?>
                    <tr <?php if (isset($p['is_read'])) if ($p['is_read'] == 0) { ?> class="new-row" onclick="readRating('<?php echo $p['rating_ID'] ?>')" <?php } ?> data-row="<?php echo $p['rating_ID'] ?>">
                      <td><?php echo $i; ?></td>
                      <td><?php echo $this->MRestBranch->getUserName($p['user_ID']); ?></td>
                      <td><?php $total += $p['rating_Food'];
                          echo $p['rating_Food']; ?></td>
                      <td><?php $total += $p['rating_Service'];
                          echo $p['rating_Service']; ?></td>
                      <td><?php $total += $p['rating_Atmosphere'];
                          echo $p['rating_Atmosphere']; ?></td>
                      <td><?php $total += $p['rating_Value'];
                          echo $p['rating_Value']; ?></td>
                      <td><?php $total += $p['rating_Presentation'];
                          echo $p['rating_Presentation']; ?></td>
                      <td><?php $total += $p['rating_Variety'];
                          echo $p['rating_Variety']; ?></td>
                      <td>
                        <?php $p_total = round(($total * 10) / 6, 2);
                        $class = "bg-primary";
                        if ($p_total <= 50)
                          $class = "bg-secondary";
                        ?>
                        <div class="progress-showcase">
                          <?= $p_total ?>%
                          <div class="progress" style="height: 8px;">
                            <div class="progress-bar <?= $class ?>" role="progressbar" style="width: <?= $p_total ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </td>
                    </tr>
                  <?php } ?>
                <?php } else { ?>
                  <tr>
                    <td colspan="8">&nbsp;&nbsp;<?= lang('no_rating_yet') ?> </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>

        </div>
        </div>
        <script src="<?= base_url(js_path()) ?>/datatable/jquery.dataTables.min.js"></script>
<script src="<?= base_url(js_path()) ?>/datatable/datatable.custom.js"></script>