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
                                        'new/'
                                            => new Eruda_Router(    //Admin-Entradas-New Router
                                                array(
                                                    new Eruda_CF('Admin', 'EntradaForm'),
                                                    new Eruda_CF('Admin', 'EntradaPut', 'PUT'),
                                                    new Eruda_CF('Admin', 'EntradaPut', 'POST')
                                                )
                                        )
                                    )           
                            ),
                            'comentarios/'
                                 => new Eruda_Router(    //Admin-Entradas Router
                                    new Eruda_CF('Admin', 'CommentsList'),
                                    array(
                                        '([0-9]+)/'
                                            => new Eruda_Router(    //Admin-Entradas-Edit Router
                                                new Eruda_CF('Error', 'E404'),
                                                array(
                                                    'valid/' => 
                                                        new Eruda_Router( 
                                                            new Eruda_CF('Admin', 'CommentsValid')
                                                        ),
                                                    'delete/' => 
                                                        new Eruda_Router( 
                                                            new Eruda_CF('Admin', 'CommentsDelete')
                                                        )
                                                )
                                        )
                                    )     
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
                                                    new Eruda_CF('Admin', 'AvisosPut', 'POST')
                                                )
                                        ),
                                        'edit/'
                                            => new Eruda_Router(    //Admin-Avisos-New Router
                                                array(
                                                    new Eruda_CF('Admin', 'AvisosPost', 'POST')
                                                )
                                        )
                                    )        
                                        
                            ),
                            'manga/'
                                => new Eruda_Router(    //Admin-Entradas Router
                                    array(
                                        new Eruda_CF('Admin', 'MangaList'),
                                        new Eruda_CF('Admin', 'AddMangaSerie', 'POST')
                                    ),
                                    array(
                                        '([0-9]+)/'
                                            => new Eruda_Router(    //Admin-Entradas-Edit Router
                                                array(
                                                    new Eruda_CF('Admin', 'MangaGet'),
                                                    new Eruda_CF('Admin', 'MangaPost', 'POST')
                                                )
                                        ),
                                        'new/'
                                            => new Eruda_Router(    //Admin-Entradas-New Router
                                                array(
                                                    new Eruda_CF('Admin', 'MangaForm'),
                                                    new Eruda_CF('Admin', 'MangaPut', 'PUT'),
                                                    new Eruda_CF('Admin', 'MangaPut', 'POST')
                                                )
                                        ),
                                        'serie/'
                                            => new Eruda_Router(    //Admin-Entradas-New Router
                                                new Eruda_CF('Error', 'E404'),
                                                array(
                                                    '([0-9]+)/'
                                                        => new Eruda_Router(    //VistaPrevia Comment
                                                                array(
                                                                    new Eruda_CF('Admin', 'MangaSeriePost', 'POST'),
                                                                    new Eruda_CF('Admin', 'MangaSerieGet')
                                                                ),array(
                                                                    'delete/'
                                                                        => new Eruda_Router(    //Admin-Entradas-Edit Router
                                                                            array(
                                                                                new Eruda_CF('Admin', 'MangaSerieDelete', 'DELETE'),
                                                                                new Eruda_CF('Admin', 'MangaSerieDelete', 'POST')
                                                                            )
                                                                    )
                                                                )
                                                        )
                                                    )
                                        )
                                    )  
                            ),
                            'anime/'
                                => new Eruda_Router(    //Admin-Entradas Router
                                    array(
                                        new Eruda_CF('Admin', 'AnimeList'),
                                        new Eruda_CF('Admin', 'AddAnimeSerie', 'POST')
                                    ),
                                    array(
                                        '([0-9]+)/'
                                            => new Eruda_Router(    //Admin-Entradas-Edit Router
                                                array(
                                                    new Eruda_CF('Admin', 'AnimeGet'),
                                                    new Eruda_CF('Admin', 'AnimePost', 'POST')
                                                )
                                        ),
                                        'new/'
                                            => new Eruda_Router(    //Admin-Entradas-New Router
                                                array(
                                                    new Eruda_CF('Admin', 'AnimeForm'),
                                                    new Eruda_CF('Admin', 'AnimePut', 'PUT'),
                                                    new Eruda_CF('Admin', 'AnimePut', 'POST')
                                                )
                                        ),
                                        'serie/'
                                            => new Eruda_Router(    //Admin-Entradas-New Router
                                                new Eruda_CF('Error', 'E404'),
                                                array(
                                                    '([0-9]+)/'
                                                        => new Eruda_Router(    //VistaPrevia Comment
                                                                array(
                                                                    new Eruda_CF('Admin', 'AnimeSeriePost', 'POST'),
                                                                    new Eruda_CF('Admin', 'AnimeSerieGet')
                                                                ),array(
                                                                    'delete/'
                                                                        => new Eruda_Router(    //Admin-Entradas-Edit Router
                                                                            array(
                                                                                new Eruda_CF('Admin', 'AnimeSerieDelete', 'DELETE'),
                                                                                new Eruda_CF('Admin', 'AnimeSerieDelete', 'POST')
                                                                            )
                                                                    )
                                                                )
                                                        )
                                                    )
                                        )
                                    )  
                            ),
                            'proyectos/'
                                => new Eruda_Router(    //Admin-Proyectos Router
                                    /*TO-DO*/
                            )
                        )   
                ),
                'ajax/' 
                    => new Eruda_Router(    //Ajax Router
                        new Eruda_CF('Error', 'E404'),
                        array(
                            'previewcomment/' 
                                => new Eruda_Router(    //VistaPrevia Comment
                                        new Eruda_CF('Ajax', 'Preview', 'POST')
                                ),
                            'lastmanga/' 
                                => new Eruda_Router(    //Get Last manga
                                        new Eruda_CF('Ajax', 'LastManga')
                                ),
                            'lastanime/' 
                                => new Eruda_Router(    //Get Last anime
                                        new Eruda_CF('Ajax', 'LastAnime')
                                )
                            )
                ),
                'device/' 
                    => new Eruda_Router(    //Ajax Router
                        new Eruda_CF('Error', 'E404'),
                        array(
                            'pc/' 
                                => new Eruda_Router(    //VistaPrevia Comment
                                        new Eruda_CF('Config', 'Change2PC')
                                ),
                            'mobile/' 
                                => new Eruda_Router(    //VistaPrevia Comment
                                        new Eruda_CF('Config', 'Change2Mobile')
                                )
                            )
                ),
                'rss/' 
                    => new Eruda_Router(    
                        new Eruda_CF('RSS', 'index'),
                        array(
                            'all/' 
                                => new Eruda_Router(    
                                        new Eruda_CF('RSS', 'all')
                                ),
                            '([a-z][0-9a-z_-]*)/' 
                                => new Eruda_Router(    
                                        new Eruda_CF('RSS', 'category')
                                )
                            )
                ),
                'sitemap.xml' 
                    => new Eruda_Router(    
                        new Eruda_CF('sitemap', 'index')
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
                            'facebook/' 
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
                            '([^/]+)/'
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
                            '([^/]+)/'
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
                            '([0-9]+)/([^/]*)/' 
                                => new Eruda_Router(    //Proyectos-Serie Router
                                    new Eruda_CF('Proyecto', 'Serie')
                            )
                        )
                ),
                'p([0-9]+)/' 
                    => new Eruda_Router(    //Paginacion Router
                        new Eruda_CF('Entrada', 'Paginacion')
                ),
                '([^/]*)/' 
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