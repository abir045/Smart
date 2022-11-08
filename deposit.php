<?php

session_start();
require_once('server/db.php');
include('comp/functions.php');

if (!isset($_SESSION["loggedin"])){
    header('Location: login.php');
}

$id = $_SESSION["id"];
$username = $_SESSION["username"];


?>


<!doctype html>
<html lang="en">

<head>
    <?php include('comp/head.php'); ?>
    <title><?php echo $site_name; ?> - Deposit</title>
</head>

<body data-topbar="dark" data-layout-mode="dark" data-sidebar="dark">
    <div id="layout-wrapper">
        <?php include 'comp/nav.php'; ?>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Deposit</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Deposit</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
          
                        if(isset($_GET['error'])){
                            $error = urldecode($_GET['error']);
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> '.$error.'
                            </div>';

                        }elseif(isset($_GET['success'])){
                            $success = urldecode($_GET['success']);
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> '.$success.'
                            </div>';
                        }


                    ?>

                    <div class="row layout-spacing">

                        <!-- Content -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">

                            <div class="bio layout-spacing ">
                                <div class="widget-content widget-content-area">


                                    <form role="form" action="gateway.php" method="post" target="_blank">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label class="form-label">Amount (Min 5.00$)</label>
                                            <input name="amount" type="number" min="5" class="form-control"
                                                placeholder="200">
                                        </div>


                                        <div class="form-group">
                                            <label class="form-label">Available Payment Methods</label>
                                            <div class="row" style="margin: auto;">

                                                <div style="width:fit-content; margin: auto;">
                                                    <img style="width: 40px;" src="data:image/png;base64,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" alt="">
                                                    <img style="width: 40px;" src="data:image/png;base64,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" alt="">
                                                    <img style="width: 40px;" src="data:image/png;base64,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" alt="">
                                                    <img style="width: 40px;" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAiIGhlaWdodD0iMzAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZD0iTTE1IDMwQTE1IDE1IDAgMSAwIDE1IC4wMDIgMTUgMTUgMCAwIDAgMTUgMzB6IiBmaWxsPSIjMTY1MkYwIi8+PHBhdGggZD0iTTE5LjExIDE3LjM4NGMwLTIuMTg3LTEuMzMyLTIuOTI1LTMuOTA3LTMuMjc4LTEuOTAzLS4yNzUtMi4yNjktLjcyMi0yLjI2OS0xLjYxIDAtLjg4Ny42NDQtMS40NCAxLjg3NS0xLjQ0IDEuMTIyIDAgMS43Ny4zOSAyLjAzNSAxLjI5NGEuNDc4LjQ3OCAwIDAgMCAuNDUzLjM0N2guOTg0YS40MzkuNDM5IDAgMCAwIC40NC0uNTFjLS4zMTItMS40MjgtMS4yNzQtMi4yODctMi43ODQtMi41NTZWOC4xMjVhLjQ2OS40NjkgMCAwIDAtLjQ2OC0uNDY5aC0uOTM4YS40NjkuNDY5IDAgMCAwLS40NjkuNDY5djEuNDUzYy0xLjg3NC4yNjMtMy4wNTkgMS41LTMuMDU5IDMuMDg4IDAgMi4wNTMgMS4yNSAyLjg1IDMuODYzIDMuMjAzIDEuNzc4LjI5IDIuMjg0LjY3NSAyLjI4NCAxLjY4NCAwIDEuMDEtLjg2IDEuNjg4LTIuMDcyIDEuNjg4LTEuNjM0IDAtMi4xODctLjcxNi0yLjM3Mi0xLjY0NGEuNDc1LjQ3NSAwIDAgMC0uNDYtLjM4MmgtMS4wNjhhLjQzNi40MzYgMCAwIDAtLjQzNC41MWMuMjcyIDEuNTYyIDEuMjc1IDIuNzA2IDMuMzE5IDIuOTgxdjEuNDgxYS40NjkuNDY5IDAgMCAwIC40NjguNDdoLjkzOGEuNDY5LjQ2OSAwIDAgMCAuNDY5LS40N3YtMS40OGMxLjkzNy0uMzA3IDMuMTcxLTEuNjQ1IDMuMTcxLTMuMzIzeiIgZmlsbD0iI2ZmZiIvPjxwYXRoIGQ9Ik0xMS43ODQgMjMuOTYyYTkuMzc1IDkuMzc1IDAgMCAxIDAtMTcuNjEyLjY3Ni42NzYgMCAwIDAgLjQwMy0uNTkxdi0uODc1YS40NDMuNDQzIDAgMCAwLS42MjQtLjQ0NyAxMS4yNSAxMS4yNSAwIDAgMCAwIDIxLjQzOC40NDMuNDQzIDAgMCAwIC42MjQtLjQ0N3YtLjg3NWEuNjc2LjY3NiAwIDAgMC0uNDAzLS41OXpNMTguNDM3IDQuNDM3YS40NDQuNDQ0IDAgMCAwLS42MjUuNDQ3di44NzVhLjY3NC42NzQgMCAwIDAgLjQwMy41OSA5LjM3NiA5LjM3NiAwIDAgMSAwIDE3LjYxMy42MjUuNjI1IDAgMCAwLS40MDMuNTl2Ljg3NmEuNDQ0LjQ0NCAwIDAgMCAuNjI1LjQ0NyAxMS4yNSAxMS4yNSAwIDAgMCAwLTIxLjQzOHoiIGZpbGw9IiNmZmYiLz48L3N2Zz4K" alt="">
                                                    <img style="width: 40px;" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDIyLjAuMSwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPgo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IgoJIHZpZXdCb3g9IjAgMCAzMiAzMiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMzIgMzI7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPHN0eWxlIHR5cGU9InRleHQvY3NzIj4KCS5zdDB7ZmlsbDojRjVBQzM3O30KCS5zdDF7ZmlsbDojRkVGRUZEO30KPC9zdHlsZT4KPGc+Cgk8Y2lyY2xlIGNsYXNzPSJzdDAiIGN4PSIxNiIgY3k9IjE2IiByPSIxNiIvPgoJPHBhdGggY2xhc3M9InN0MSIgZD0iTTguMzc1LDI0Ljg3NWMtMC4wMDEtMC4wMTgtMC4wMDItMC4wMzYtMC4wMDMtMC4wNTVjMC4wMTQtMC43NzgsMC4wMTYtMS41NTUsMC0yLjMzMwoJCWMwLjAwMy0wLjI2MiwwLjAwNy0wLjUyNCwwLjAwOC0wLjc4N2MwLjAwMS0wLjc4Mi0wLjAwMy0xLjU2NCwwLjAwNC0yLjM0NmMwLjAwMS0wLjEzMS0wLjA0My0wLjE1OC0wLjE2Mi0wLjE1OAoJCWMtMC43MjQsMC4wMDQtMS40NDktMC4wMDEtMi4xNzMsMC4wMDNjLTAuMTIyLDAuMDAxLTAuMTctMC4wMzItMC4xNjktMC4xNTdjMC4wMDUtMC42MzUsMC4wMDUtMS4yNywwLjAwNy0xLjkwNQoJCWMwLjc3MS0wLjAwMywxLjU0My0wLjAxLDIuMzE0LTAuMDA3YzAuMTM0LDAuMDAxLDAuMTg0LTAuMDI4LDAuMTgyLTAuMTcyYy0wLjAwOC0wLjYyNC0wLjAwNy0xLjI0OS0wLjAwMi0xLjg3MwoJCWMwLjAwMS0wLjEyMy0wLjA0NC0wLjE1MS0wLjE1Ni0wLjE1MWMtMC43MjQsMC4wMDQtMS40NDgsMC0yLjE3MywwLjAwNmMtMC4xMjIsMC4wMDEtMC4xNjgtMC4wMzEtMC4xNjctMC4xNTYKCQljMC4wMDMtMC41ODgsMC0xLjE3NS0wLjAwMi0xLjc2M2MtMC4wMDEtMC4xMDgsMC4wNDUtMC4xNDQsMC4xNTMtMC4xNDRjMC43MTksMC4wMDMsMS40MzgtMC4wMDIsMi4xNTcsMC4wMDQKCQljMC4xNDUsMC4wMDEsMC4xOS0wLjA0MywwLjE4OS0wLjE4N2MtMC4wMDYtMC44ODItMC4wMDQtMS43NjMtMC4wMDQtMi42NDVjMC0wLjkxNSwwLjAwNS0xLjgzMS0wLjAwMi0yLjc0NgoJCWMtMC4wMDEtMC4xNjcsMC4wNTctMC4yLDAuMjA4LTAuMTk5YzEuNDE3LDAuMDA0LDIuODM0LDAuMDAxLDQuMjUxLDAuMDAyYzEuMDgxLDAuMDAxLDIuMTYyLDAuMDAxLDMuMjQzLDAuMDA5CgkJYzAuNTQ2LDAuMDA0LDEuMDg1LDAuMDgzLDEuNjIyLDAuMThjMS4xMTIsMC4yMDEsMi4xNTMsMC41ODcsMy4xMjgsMS4xNTNjMC42NDgsMC4zNzYsMS4yMjcsMC44NDUsMS43NjYsMS4zNjQKCQljMC4zODgsMC40MTYsMC43NTQsMC44NDgsMS4wNjIsMS4zMjhjMC4zMTEsMC40ODMsMC41OCwwLjk4OSwwLjc4LDEuNTI4YzAuMDU2LDAuMTUyLDAuMTI3LDAuMjE5LDAuMzAxLDAuMjE1CgkJYzAuNTk3LTAuMDEzLDEuMTk1LTAuMDA2LDEuNzkyLTAuMDA2YzAuMjMsMCwwLjIzLDAuMDAyLDAuMjM5LDAuMjI0YzAuMDAxLDAuMDQyLDAuMDAxLDAuMDg0LDAuMDAyLDAuMTI2YzAsMC41MDQsMCwxLjAwOCwwLDEuNTEyCgkJYzAuMDE2LDAuMTY1LTAuMDYxLDAuMjAzLTAuMjE5LDAuMmMtMC40NjEtMC4wMTEtMC45MjIsMC4wMDItMS4zODMtMC4wMDdjLTAuMTQyLTAuMDAzLTAuMTgxLDAuMDM5LTAuMTY5LDAuMTc3CgkJYzAuMDUyLDAuNjEyLDAuMDQ3LDEuMjI0LTAuMDA1LDEuODM1Yy0wLjAxNCwwLjE2NSwwLjAzNCwwLjE4OCwwLjE4MywwLjE4N2MwLjUyOS0wLjAwNSwxLjA1OCwwLjAwNSwxLjU4NywwLjAwOQoJCWMwLjA2NiwwLjA4OC0wLjAxNCwwLjE3Ni0wLjAwMiwwLjI2N2MwLjAxNSwwLjExNywwLjAwNiwwLjIzOCwwLjAwOCwwLjM1N2MtMC4wMDIsMC40MDQtMC4wMTMsMC44MDctMC4wMDIsMS4yMTEKCQljMC4wMDUsMC4xNjEtMC4wNDgsMC4yMTEtMC4yLDAuMjExYy0wLjYyOS0wLjAwMi0xLjI1OCwwLjAxLTEuODg2LDBjLTAuMTYxLTAuMDAzLTAuMjMzLDAuMDQ5LTAuMjg4LDAuMTkyCgkJYy0wLjQ1NywxLjE5LTEuMTc3LDIuMTk5LTIuMTA1LDMuMDY3Yy0wLjMzNSwwLjMxMy0wLjcwNiwwLjU4MS0xLjA3MywwLjg1NGMtMC4zOTQsMC4yMzItMC43ODMsMC40NzMtMS4yLDAuNjYzCgkJYy0wLjc1NCwwLjM0My0xLjUzNiwwLjU5Mi0yLjM1MiwwLjc0N2MtMC43NzgsMC4xNDctMS41NiwwLjE4OS0yLjM0OCwwLjE4OGMtMi4yNTItMC4wMDQtNC41MDQtMC4wMDItNi43NTYtMC4wMDMKCQlDOC41LDI0Ljg5Myw4LjQzOCwyNC44ODEsOC4zNzUsMjQuODc1eiBNMjIuMTk0LDE5LjIxMmMtMC4xNzEtMC4wNDEtMC4zNDQtMC4wMTEtMC41MTYtMC4wMTEKCQljLTMuNjk2LTAuMDAzLTcuMzkyLTAuMDAzLTExLjA4Ny0wLjAwOWMtMC4xNTUsMC0wLjIwMiwwLjAzNS0wLjIwMSwwLjJjMC4wMDcsMS4xNTUsMC4wMDUsMi4zMS0wLjAwMywzLjQ2NQoJCWMtMC4wMDEsMC4xNiwwLjA0MywwLjIwMSwwLjIwMiwwLjIwMWMxLjcwNi0wLjAwNiwzLjQxMi0wLjAwMyw1LjExOC0wLjAwN2MwLjI0Ni0wLjAwMSwwLjQ5NCwwLjAxNCwwLjczNS0wLjA1NQoJCWMwLjc0OC0wLjA0MSwxLjQ2Ni0wLjIxNywyLjE2NC0wLjQ4YzAuMjUyLTAuMDk1LDAuNTA4LTAuMTg0LDAuNzM0LTAuMzM4YzAuMDI0LTAuMDA4LDAuMDUxLTAuMDEzLDAuMDczLTAuMDI1CgkJYzAuNTE0LTAuMjc0LDAuOTkxLTAuNjAxLDEuNDE1LTEuMDAyYzAuNTU4LTAuNTI4LDEuMDI4LTEuMTIzLDEuMzctMS44MTNDMjIuMjE5LDE5LjI5NiwyMi4yNzMsMTkuMjUxLDIyLjE5NCwxOS4yMTJ6CgkJIE0yMi4yNDMsMTIuODQ2YzAuMDA3LTAuMDQ5LTAuMDE4LTAuMDg5LTAuMDM4LTAuMTMyYy0wLjEwMS0wLjIyMy0wLjIyOS0wLjQzMi0wLjM2My0wLjYzNWMtMC4yMi0wLjMzMi0wLjQ1MS0wLjY1Ni0wLjc0NS0wLjkzCgkJYy0wLjEyMS0wLjE4LTAuMjk1LTAuMzA3LTAuNDU1LTAuNDQ2Yy0wLjg4Mi0wLjc2Ni0xLjkwNi0xLjI0NS0zLjAzNi0xLjUyM2MtMC41NTMtMC4xMzYtMS4xMTQtMC4yMTEtMS42NzQtMC4yMTkKCQljLTEuNzg5LTAuMDI1LTMuNTc5LTAuMDEtNS4zNjktMC4wMTVjLTAuMTQ4LDAtMC4xNywwLjA2NS0wLjE3LDAuMTkxYzAuMDAzLDEuMTg2LDAuMDA0LDIuMzcyLTAuMDAxLDMuNTU4CgkJYy0wLjAwMSwwLjE0OSwwLjA0OCwwLjE4NCwwLjE5LDAuMTg0YzMuODQ3LTAuMDAxLDcuNjk0LDAuMDAzLDExLjU0MSwwLjAwNEMyMi4xNjQsMTIuODg0LDIyLjIxOSwxMi45MDksMjIuMjQzLDEyLjg0NnoKCQkgTTE2LjY0LDE3LjEzYzAtMC4wMDEsMC0wLjAwMiwwLTAuMDAzYzIuMDI2LDAsNC4wNTItMC4wMDEsNi4wNzgsMC4wMDNjMC4xMzEsMCwwLjE5LTAuMDM3LDAuMjAxLTAuMTcxCgkJYzAuMDUxLTAuNjE4LDAuMDUtMS4yMzYsMC4wMDEtMS44NTRjLTAuMDEtMC4xMjMtMC4wNjEtMC4xNy0wLjE4OS0wLjE3Yy00LjA1MiwwLjAwMy04LjEwNCwwLjAwNC0xMi4xNTUsMAoJCWMtMC4xNDcsMC0wLjE4OCwwLjA0NC0wLjE4NywwLjE4OGMwLjAwNiwwLjU5MywwLjAwMiwxLjE4NiwwLjAwMSwxLjc3OWMwLDAuMjI4LDAsMC4yMjksMC4yMzYsMC4yMjkKCQlDMTIuNjMxLDE3LjEzLDE0LjYzNSwxNy4xMywxNi42NCwxNy4xM3oiLz4KPC9nPgo8L3N2Zz4K" alt="">
                                                    <img style="width: 40px;"  src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAzMiAzMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTE2IDMyQzI0LjgzNjYgMzIgMzIgMjQuODM2NiAzMiAxNkMzMiA3LjE2MzQ0IDI0LjgzNjYgMCAxNiAwQzcuMTYzNDQgMCAwIDcuMTYzNDQgMCAxNkMwIDI0LjgzNjYgNy4xNjM0NCAzMiAxNiAzMloiIGZpbGw9IiM4REMzNTEiLz4KPHBhdGggZD0iTTIxLjIwNzEgMTAuNTM0QzIwLjQzMTEgOC41NjIgMTguNDg1MSA4LjM4NCAxNi4yMTkxIDguODI0TDE1LjQxMjEgNi4wMTFMMTMuNzAwMSA2LjUwMkwxNC40ODYxIDkuMjQyQzE0LjAzNjEgOS4zNyAxMy41NzgxIDkuNTEyIDEzLjEyMzEgOS42NTJMMTIuMzMzMSA2Ljg5NEwxMC42MjIxIDcuMzg0TDExLjQyNzEgMTAuMTk3QzExLjA1OTEgMTAuMzExIDEwLjY5NzEgMTAuNDIzIDEwLjM0MjEgMTAuNTI1TDEwLjMzOTEgMTAuNTE1TDcuOTc3MDUgMTEuMTkyTDguNTAyMDUgMTMuMDIyQzguNTAyMDUgMTMuMDIyIDkuNzYwMDUgMTIuNjM0IDkuNzQ1MDUgMTIuNjY0QzEwLjQzOTEgMTIuNDY1IDEwLjc4MDEgMTIuODAzIDEwLjk0NTEgMTMuMTMyTDExLjg2NTEgMTYuMzM2QzExLjkxMjEgMTYuMzIzIDExLjk3NTEgMTYuMzA3IDEyLjA0OTEgMTYuMjk2TDExLjg2ODEgMTYuMzQ4TDEzLjE1NTEgMjAuODM4QzEzLjE4NzEgMjEuMDY1IDEzLjE1OTEgMjEuNDUgMTIuNjc1MSAyMS41OUMxMi43MDIxIDIxLjYwMyAxMS40MjkxIDIxLjk0NiAxMS40MjkxIDIxLjk0NkwxMS42NzYxIDI0LjA4OUwxMy45MDQxIDIzLjQ0OUMxNC4zMTkxIDIzLjMzMiAxNC43MjkxIDIzLjIyMiAxNS4xMzAxIDIzLjEwOUwxNS45NDcxIDI1Ljk1NEwxNy42NTcxIDI1LjQ2NEwxNi44NTAxIDIyLjY0OUMxNy4zMDg3IDIyLjUyNzMgMTcuNzY2MSAyMi40MDA2IDE4LjIyMjEgMjIuMjY5TDE5LjAyNDEgMjUuMDcyTDIwLjczNzEgMjQuNTgxTDE5LjkyMzEgMjEuNzQxQzIyLjc1NDEgMjAuNzUgMjQuNTYxMSAxOS40NDcgMjQuMDM2MSAxNi42NzFDMjMuNjE0MSAxNC40MzcgMjIuMzEyMSAxMy43NTkgMjAuNTY1MSAxMy44MzVDMjEuNDEzMSAxMy4wNDUgMjEuNzc4MSAxMS45NzcgMjEuMjA3MSAxMC41MzVWMTAuNTM0Wk0yMC41NTcgMTcuMzA0QzIxLjE2NyAxOS40MzEgMTcuNDU3MSAyMC4yMzMgMTYuMjk3MSAyMC41NjdMMTUuMjE2MSAxNi43OTdDMTYuMzc2IDE2LjQ2NCAxOS45MjAxIDE1LjA4NyAyMC41NTYxIDE3LjMwNUwyMC41NTcgMTcuMzA0Wk0xOC4yMzUxIDEyLjIxNEMxOC43ODkxIDE0LjE0OSAxNS42ODgxIDE0Ljc5NCAxNC43MjExIDE1LjA3MUwxMy43NDExIDExLjY1MkMxNC43MDcxIDExLjM3NSAxNy42NTYxIDEwLjE5NyAxOC4yMzUxIDEyLjIxNVYxMi4yMTRaIiBmaWxsPSJ3aGl0ZSIvPgo8L3N2Zz4K" alt="">
                                                </div>
                                                        

                                            </div>

                                            <input id="payment_val" name="payment_method" type="hidden" class="form-control" value="other" required>
                                        </div>

                                        <button class="waves-effect waves-light btn btn-primary mb-5" type="submit" style="width: 100%;margin-block: 20px;">Deposit</button>

                                    </form>
                                </div>
                            </div>
                        </div>

                <!-- Content -->
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">

                    <div class="bio layout-spacing ">
                        <div class="widget-content widget-content-area">
                            <h3 class="">History</h3>


                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
            
										$showorders = mysqli_query($conn, "SELECT * FROM billing WHERE `user_id`='$id' ORDER BY id DESC;");
								
										while($row = mysqli_fetch_array($showorders)) { 
                                            //remove "charge:" from the string
                                            if($row['status'] == 'pending' || $row['status'] == 'charge:created') {
                                                $status = '<span class="badge bg-warning">Created</span>';
                                            }elseif($row['status'] == 'charge:confirmed') {
                                                $status = '<span class="badge bg-success">Paid</span>';
                                            }else{
                                                $status = '<span class="badge bg-danger">'.str_replace("charge:","",$row['status']).'</span>';
                                            }
                                            

											echo '            
											<tr>
											<td>'.$row['amount'].'</td>
											<td>'.$status.'</td>
											<td>'.$row['created_at'].'</td>
                                            <td>';

                                            if($row['status'] == 'pending' || $row['status'] == 'charge:created') {
                                                echo '<a href="'.$row['url'].'" class="btn btn-success">Invoice</a>';
                                            }

                                            echo '</td>
											</tr>';
										}

										?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <?php include 'comp/footer.php'; ?>
    </div>
    </div>

    <div class="rightbar-overlay"></div>
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <script src="assets/js/app.js"></script>



    <style>
    .popSelect {
        flex-direction: column;
        margin: auto;
        height: 250px;
        width: 200px;
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        cursor: pointer;
        transition: all 0.3s ease;
        opacity: 0.3;
    }

    .popSelect.active {
        opacity: 1;
        border: 4px solid #1b55e2;
    }

    .popSelect.active img {
        -webkit-filter: none !important;
        filter: none !important;
    }



    .popSelect:hover {
        transform: scale(1.06);
    }
    </style>

    <script>
    $(document).ready(function() {


        $('.popSelect').click(function() {

            $('.popSelect').removeClass('active');
            $(this).addClass('active');
            
        });



    });
    </script>
    <script src="assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->


</body>

</html>