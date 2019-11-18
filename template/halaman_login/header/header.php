<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <base href="<?php echo base_url(); ?>">
    <title><?php echo $title; ?></title>
    <link rel="shortcut icon" href="<?php echo base_url() ?>images/logo/logouit.png">
    <link href="<?php echo base_url() ?>template/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>template/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- CUSTOM STYLE  -->
    <link href="<?php echo base_url() ?>template/vendors/style.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>template/vendors/dist/css/demo.css" rel="stylesheet" />
    <style>
        #loading{
            width: 50px;
            height: 50px;
            border: solid 5px #ccc;
            border-top-color: #ff6a00;
            border-radius: 100%;

            position: fixed;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            margin: auto;

            animation: putar 2s linear infinite;
        }
        @keyframes putar{
            from{transform: rotate(0deg) }
            to{transform: rotate(360deg) }
        }
    </style>
</head>
