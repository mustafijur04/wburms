<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="container">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">Menu</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-inner mt--5">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body mt-2">
                        <div class="row">                           
                            <div class="col-md-3">
                                <a href="<?= base_url('roads/overview') ?>">
                                    <div class="card card-stats card-warning card-round" style="background: linear-gradient(135deg, #618effff, #1e8ae9ff) !important;">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 col-stats">
                                                    <div class="numbers">
                                                        <p class="card-category">Pathashree Urban</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-inner mt--5">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body mt-3">
                        <div class="row">
                            <div class="col-md-3">
                                <a href="<?= base_url('um') ?>">
                                    <div class="card card-stats card-danger card-round" style="background-color: #8E24AA !important;">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 col-stats">
                                                    <div class="numbers">
                                                        <p class="card-category">User Management</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            
                            <div class="col-md-3">
                                <a href="<?= base_url('log/view') ?>">
                                    <div class="card card-stats card-secondary card-round">
                                        <div class="card-body">
                                            <div class="row" style="text-align: center;">
                                                <div class="col-12 col-stats">
                                                    <div class="numbers">
                                                        <p class="card-category">Call Log / Support</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>


