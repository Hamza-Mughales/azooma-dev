<head>
    <title>{{ $pagetitle }} | {{ $sitename }} </title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <link rel="shortcut icon" href="<?php echo URL::to('favicon.ico'); ?>" />        
    <script type="text/javascript">
        var base = '<?php echo route("home"); ?>';
        var adminbase = '<?php echo route("adminhome"); ?>';
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">


    
    <script src="<?= asset(js_path() . 'jquery-3.5.1.min.js' )?>" ></script>
    <link href="<?= asset(css_path() . 'admin.css' )?>"  rel="stylesheet">
    <link href="<?= asset(css_path() . 'bootstrap.css' )?>"  rel="stylesheet">
    <link href="<?= asset(css_path() . 'animate.css' )?>"  rel="stylesheet">
    <link href="<?= asset(css_path() . 'css/font-awesome.min.css' )?>"  rel="stylesheet">
    <link href="<?= asset(css_path() . 'scrollbar.css' )?>"  rel="stylesheet">
    <link href="<?= asset(css_path() . 'datatable/datatable.css' )?>"  rel="stylesheet">
    <link href="<?= asset(css_path() . 'flag-icon.css' )?>"  rel="stylesheet">
    <link href="<?= asset(css_path() . 'style.css' )?>"  rel="stylesheet">
    <link href="<?= asset(css_path() . 'color-1.css' )?>"  rel="stylesheet">
    <link href="<?= asset(css_path() . 'responsive.css' )?>"  rel="stylesheet">
    <link href="<?= asset(css_path() . 'select2.min.css' )?>"  rel="stylesheet">
    <link href="<?= asset(css_path() . 'sweetalert2.css' )?>"  rel="stylesheet">
    <link href="<?= asset(css_path() . 'main_style.css' )?>"  rel="stylesheet">
<script>
 var dataTable_lang ={
    "emptyTable": "<?=__('No data available in table')?>",
    "info": "<?= __('Showing _START_ to _END_ of _TOTAL_ entries')?>",
    "infoEmpty": "<?= __('Showing 0 to 0 of 0 entries')?>",
    "infoFiltered": "<?= __('(filtered from _MAX_ total entries)')?>",
    "lengthMenu": "<?= __('Show _MENU_ entries')?>",
    "loadingRecords": "<?= __('Loading...')?>",
    "processing": "<?= __('Processing...')?>",
    "search": "<?= __('Search: ')?>",
    "zeroRecords": "<?= __('No matching records found')?>",
    "paginate": {
        "first": "<?= __('First')?>",
        "last": "<?= __('Last')?>",
        "next": "<?=__('Next')?>",
        "previous": "<?=__('Previous')?>"
    },
 

} ;
</script>

</head>

