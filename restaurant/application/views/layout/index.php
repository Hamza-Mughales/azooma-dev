<?php $this->load->view('layout/header'); ?>

    <?php $this->load->view('layout/topbar'); ?>

        <?php $this->load->view('layout/sidebar'); ?>
        <main class="page-body">
            <?php $this->load->view($subview);  ?>
        </main>
  

<?php $this->load->view('layout/footer'); ?>