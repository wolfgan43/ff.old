<?php
/**
 * VGallery: CMS based on FormsFramework
 * Copyright (C) 2004-2015 Alessandro Stucchi <wolfgan@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *  @package VGallery
 *  @subpackage core
 *  @author Alessandro Stucchi <wolfgan@gmail.com>
 *  @copyright Copyright (c) 2004, Alessandro Stucchi
 *  @license http://opensource.org/licenses/gpl-3.0.html
 *  @link https://github.com/wolfgan43/vgallery
 */

$html = '
<div class="row">
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Default Buttons</h4>
                                        <p class="text-muted font-14">Use the button classes on an <code>&lt;a&gt;</code>, <code>&lt;button&gt;</code>, or <code>&lt;input&gt;</code> element.</p>

                                        <div class="button-list">
                                            <button type="button" class="btn btn-primary">Primary</button>
                                            <button type="button" class="btn btn-secondary">Secondary</button>
                                            <button type="button" class="btn btn-success">Success</button>
                                            <button type="button" class="btn btn-danger">Danger</button>
                                            <button type="button" class="btn btn-warning">Warning</button>
                                            <button type="button" class="btn btn-info">Info</button>
                                            <button type="button" class="btn btn-light">Light</button>
                                            <button type="button" class="btn btn-dark">Dark</button>
                                            <button type="button" class="btn btn-link">Link</button>
                                        </div>

                                        <h4 class="header-title mt-4">Button Bordered</h4>
                                        <p class="text-muted font-14">Use a classes <code>.btn-outline-**</code> to quickly create a bordered buttons.</p>

                                        <div class="button-list">
                                            <button type="button" class="btn btn-outline-primary">Primary</button>
                                            <button type="button" class="btn btn-outline-secondary">Secondary</button>
                                            <button type="button" class="btn btn-outline-success">Success</button>
                                            <button type="button" class="btn btn-outline-danger">Danger</button>
                                            <button type="button" class="btn btn-outline-warning">Warning</button>
                                            <button type="button" class="btn btn-outline-info">Info</button>
                                            <button type="button" class="btn btn-outline-light">Light</button>
                                            <button type="button" class="btn btn-outline-dark">Dark</button>
                                        </div>

                                        <h4 class="header-title mt-4">Button-Rounded</h4>
                                        <p class="text-muted font-14">Add <code>.btn-rounded</code> to default button to get rounded corners.</p>

                                        <div class="button-list">
                                            <button type="button" class="btn btn-primary btn-rounded">Primary</button>
                                            <button type="button" class="btn btn-secondary btn-rounded">Secondary</button>
                                            <button type="button" class="btn btn-success btn-rounded">Success</button>
                                            <button type="button" class="btn btn-danger btn-rounded">Danger</button>
                                            <button type="button" class="btn btn-warning btn-rounded">Warning</button>
                                            <button type="button" class="btn btn-info btn-rounded">Info</button>
                                            <button type="button" class="btn btn-light btn-rounded">Light</button>
                                            <button type="button" class="btn btn-dark btn-rounded">Dark</button>
                                            <button type="button" class="btn btn-link btn-rounded">Link</button>
                                        </div>

                                        <h4 class="header-title mt-4">Button Bordered Rounded</h4>
                                        <p class="text-muted font-14">Use a classes <code>.btn-outline-**</code> to quickly create a bordered buttons.</p>

                                        <div class="button-list">
                                            <button type="button" class="btn btn-outline-primary btn-rounded">Primary</button>
                                            <button type="button" class="btn btn-outline-secondary btn-rounded">Secondary</button>
                                            <button type="button" class="btn btn-outline-success btn-rounded">Success</button>
                                            <button type="button" class="btn btn-outline-danger btn-rounded">Danger</button>
                                            <button type="button" class="btn btn-outline-warning btn-rounded">Warning</button>
                                            <button type="button" class="btn btn-outline-info btn-rounded">Info</button>
                                            <button type="button" class="btn btn-outline-light btn-rounded">Light</button>
                                            <button type="button" class="btn btn-outline-dark btn-rounded">Dark</button>
                                        </div>

                                        <h4 class="header-title mt-4">Button-Sizes</h4>
                                        <p class="text-muted font-14">
                                            Add <code>.btn-lg</code>, <code>.btn-sm</code> for additional sizes.
                                        </p>

                                        <div class="button-list">
                                            <button type="button" class="btn btn-primary btn-lg">Large</button>
                                            <button type="button" class="btn btn-info">Normal</button>
                                            <button type="button" class="btn btn-success btn-sm">Small</button>
                                        </div>

                                        <h4 class="header-title mt-4">Button-Disabled</h4>

                                        <p class="text-muted font-14">
                                            Add the <code>disabled</code> attribute to <code>&lt;button&gt;</code> buttons.
                                        </p>
    
                                        <div class="button-list">
                                            <button type="button" class="btn btn-info" disabled>Info</button>
                                            <button type="button" class="btn btn-success" disabled>Success</button>
                                            <button type="button" class="btn btn-danger" disabled>Danger</button>
                                            <button type="button" class="btn btn-dark" disabled>Dark</button>
                                        </div>

                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col -->

                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
    
                                        <h4 class="header-title">Icon Button</h4>

                                        <p class="text-muted font-14">
                                            Icon only button.
                                        </p>
    
                                        <div class="button-list">
                                            <button type="button" class="btn btn-icon btn-light"> <i class="mdi mdi-heart-outline"></i> </button>
                                            <button type="button" class="btn btn-icon btn-danger"> <i class="mdi mdi-window-close"></i> </button>
                                            <button type="button" class="btn btn-icon btn-dark"> <i class="mdi mdi-music"></i> </button>
                                            <button type="button" class="btn btn-icon btn-primary"> <i class="mdi mdi-star"></i> </button>
                                            <button type="button" class="btn btn-icon btn-success"> <i class="mdi mdi-thumb-up-outline"></i> </button>
                                            <button type="button" class="btn btn-icon btn-info"> <i class="mdi mdi-keyboard"></i> </button>
                                            <button type="button" class="btn btn-icon btn-warning"> <i class="mdi mdi-wrench"></i> </button>
                                            <br>
                                            <button type="button" class="btn btn-light"> <i class="mdi mdi-heart mr-1"></i> <span>Like</span> </button>
                                            <button type="button" class="btn btn-warning"> <i class="mdi mdi-rocket mr-1"></i> <span>Launch</span> </button>
                                            <button type="button" class="btn btn-info"> <i class="mdi mdi-cloud mr-1"></i> <span>Cloud Hosting</span> </button>
                                        </div>
    
                                        <h4 class="header-title mt-4">Block Button</h4>

                                        <p class="text-muted font-14">
                                            Create block level buttons,with by adding add <code>.btn-block</code>.
                                        </p>
    
                                        <button type="button" class="btn btn-block btn-primary">Block Button</button>
                                        <button type="button" class="btn btn-block btn-sm btn-info">Block Button</button>
                                        <button type="button" class="btn btn-block btn-xs btn-success">Block Button</button>
    
                                        <h4 class="header-title mt-4">Button Group</h4>

                                        <p class="text-muted font-14">
                                            Wrap a series of buttons with <code>.btn</code> in <code>.btn-group</code>.
                                        </p>
    
                                        <div class="btn-group mb-2">
                                            <button type="button" class="btn btn-light">Left</button>
                                            <button type="button" class="btn btn-light">Middle</button>
                                            <button type="button" class="btn btn-light">Right</button>
                                        </div>

                                        <br>
    
                                        <div class="btn-group mb-2">
                                            <button type="button" class="btn btn-light">1</button>
                                            <button type="button" class="btn btn-light">2</button>
                                            <button type="button" class="btn btn-light">3</button>
                                            <button type="button" class="btn btn-light">4</button>
                                        </div>

                                        <div class="btn-group mb-2">
                                            <button type="button" class="btn btn-light">5</button>
                                            <button type="button" class="btn btn-light">6</button>
                                            <button type="button" class="btn btn-light">7</button>
                                        </div>

                                        <div class="btn-group mb-2">
                                            <button type="button" class="btn btn-light">8</button>
                                        </div>

                                        <br>

                                        <div class="btn-group mb-2">
                                            <button type="button" class="btn btn-light">1</button>
                                            <button type="button" class="btn btn-primary">2</button>
                                            <button type="button" class="btn btn-light">3</button>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Dropdown <span class="caret"></span> </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#">Dropdown link</a>
                                                    <a class="dropdown-item" href="#">Dropdown link</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="btn-group-vertical mb-2">
                                                    <button type="button" class="btn btn-light">Top</button>
                                                    <button type="button" class="btn btn-light">Middle</button>
                                                    <button type="button" class="btn btn-light">Bottom</button>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="btn-group-vertical mb-2">
                                                    <button type="button" class="btn btn-light">Button 1</button>
                                                    <button type="button" class="btn btn-light">Button 2</button>
                                                    <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Button 3 <span class="caret"></span> </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#">Dropdown link</a>
                                                        <a class="dropdown-item" href="#">Dropdown link</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->
                        
';
$cm->oPage->addContent($html);
