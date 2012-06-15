<?php
/* @var $router Eruda_Router */
$router = new Eruda_Router(     //Index Router
            new Eruda_CF('Entrada'),
            array(
                'admin/' 
                    => new Eruda_Router(    //Admin Router
                        new Eruda_CF('Admin'),
                        array(
                            'entradas/'
                                => new Eruda_Router(    //Admin-Entradas Router
                                    new Eruda_CF('Admin', 'EntradasList'),
                                    array(
                                        '([0-9]+)/'
                                            => new Eruda_Router(    //Admin-Entradas-Edit Router
                                                array(
                                                    new Eruda_CF('Admin', 'EntradaGet'),
                                                    new Eruda_CF('Admin', 'EntradaPost', 'POST')
                                                )
                                        ),
                                        'ver/([0-9]+)/'
                                            => new Eruda_Router(    //Admin-Entradas Router
                                                new Eruda_CF('Admin', 'EntradaVer')
                                        ),
                                        'new/'
                                            => new Eruda_Router(    //Admin-Entradas-New Router
                                                array(
                                                    new Eruda_CF('Admin', 'EntradaForm'),
                                                    new Eruda_CF('Admin', 'EntradaPut', 'PUT'),
                                                    new Eruda_CF('Admin', 'EntradaPut', 'POST')
                                                )
                                        ),
                                    )           
                            ),
                            'comentarios/'
                                => new Eruda_Router(    //Admin-Comentarios Router
                                    /*TO-DO*/
                            ),
                            'avisos/'
                                => new Eruda_Router(    //Admin-Avisos Router
                                    array(
                                        new Eruda_CF('Admin', 'AvisosGet'),
                                        new Eruda_CF('Admin', 'AvisosPost', 'POST'),
                                        new Eruda_CF('Admin', 'AvisosPut', 'PUT')
                                    ),
                                    array(
                                        'new/'
                                            => new Eruda_Router(    //Admin-Avisos-New Router
                                                array(
                                                    new Eruda_CF('Admin', 'AvisosPut', 'POST'),
                                                    new Eruda_CF('Admin', 'AvisosPut', 'PUT')
                                                )
                                        ),
                                    )        
                                        
                            ),
                            'manga/'
                                => new Eruda_Router(    //Admin-Manga Router
                                    /*TO-DO*/
                            ),
                            'anime/'
                                => new Eruda_Router(    //Admin-Anime Router
                                    /*TO-DO*/
                            ),
                            'proyectos/'
                                => new Eruda_Router(    //Admin-Proyectos Router
                                    /*TO-DO*/
                            )
                        )   
                ),
                'ajax/' 
                    => new Eruda_Router(    //Ajax Router
                        /*TO-DO*/
                ),
                'user/' 
                    => new Eruda_Router(    //Categorias Router
                        new Eruda_CF('Error', 'E404'),
                        array(
                            'log/' 
                                => new Eruda_Router(    //Categoria-Paginacion Router
                                        array(new Eruda_CF('User', 'LogIn', 'POST'),
                                        new Eruda_CF('User', 'LogForm', 'DEFAULT'))
                                ),
                            'register/' 
                                => new Eruda_Router(    //Categoria-Paginacion Router
                                        array(new Eruda_CF('User', 'RegisterForm'),
                                        new Eruda_CF('User', 'Register', 'POST'))
                                ),
                            'edit/' 
                                => new Eruda_Router(    //Categoria-Paginacion Router
                                        array(new Eruda_CF('User', 'EditForm'),
                                        new Eruda_CF('User', 'Edit', 'POST'))
                                ),
                            'recupera/' 
                                => new Eruda_Router(    //Categoria-Paginacion Router
                                        array(new Eruda_CF('User', 'RecuperaForm'),
                                        new Eruda_CF('User', 'Recupera', 'POST')),
                                        array(
                                            'sended/'
                                                => new Eruda_Router(    //Categoria-Paginacion Router
                                                    new Eruda_CF('User', 'RecuperaSended')
                                                ),
                                            'changed/'
                                                => new Eruda_Router(    //Categoria-Paginacion Router
                                                    new Eruda_CF('User', 'RecuperaChanged')
                                                ),
                                            '([0-9]+)-(.*)'
                                                => new Eruda_Router(    //Categoria-Paginacion Router
                                                    array(
                                                        new Eruda_CF('User', 'RecuperaMailForm'),
                                                        new Eruda_CF('User', 'RecuperaMail', 'POST')
                                                    )
                                                )
                                        )
                                ),
                            'logout/' 
                                => new Eruda_Router(    //Categoria-Paginacion Router
                                        new Eruda_CF('User', 'LogOut')
                                )
                            )
                ),
                '([0-9]+)/(.*)/' 
                    => new Eruda_Router(    //Entrada Router
                        array(
                            new Eruda_CF('Entrada', 'View'),
                            new Eruda_CF('Entrada', 'Comentar', 'POST'),
                            new Eruda_CF('Entrada', 'Comentar', 'PUT')
                        )
                ),
                '([1-9][0-9]?)-([0-9]{4})/' 
                    => new Eruda_Router(    //Archivos Router
                        new Eruda_CF('Entrada', 'Archivo')
                ),
                'manga/' 
                    => new Eruda_Router(    //Manga Router
                        new Eruda_CF('Manga'),
                        array(
                            '([0-9a-z_-]+)/'
                                => new Eruda_Router(    //Manga-Serie Router
                                        new Eruda_CF('Manga', 'Serie'),
                                        array(
                                            '([0-9a-z_-]+)/'
                                                => new Eruda_Router(    //Manga-Serie-Tomo Router
                                                        new Eruda_CF('Manga', 'Tomo')
                                            )
                                        )
                            )
                        )   
                ),
                'anime/' 
                    => new Eruda_Router(    //Anime Router
                        new Eruda_CF('Anime'),
                        array(
                            '([0-9a-z_-]+)/'
                                => new Eruda_Router(    //Anim-Serie Router
                                        new Eruda_CF('Anime', 'Serie'),
                                        array(
                                            '([0-9a-z_-]+)/'
                                                => new Eruda_Router(    //Anime-Serie-Contenedor Router
                                                        new Eruda_CF('Anime', 'Contenedor')
                                            )
                                        )
                            )
                        )
                ),
                'proyectos/' 
                    => new Eruda_Router(    //Proyectos Router
                        new Eruda_CF('Proyecto'),
                        array(
                            '([0-9]+)/(.*)/' 
                                => new Eruda_Router(    //Proyectos-Serie Router
                                    new Eruda_CF('Proyecto', 'Serie')
                            )
                        )
                ),
                'p([0-9]+)/' 
                    => new Eruda_Router(    //Paginacion Router
                        new Eruda_CF('Entrada', 'Paginacion')
                ),
                '([a-z][0-9a-z_-]*)/' 
                    => new Eruda_Router(    //Categorias Router
                        new Eruda_CF('Entrada', 'CategoriaIndex'),
                        array(
                            'p([0-9]+)/' 
                                => new Eruda_Router(    //Categoria-Paginacion Router
                                        new Eruda_CF('Entrada', 'CategoriaPaginacion')
                            )
                        )
                )
            )
        );
?>
