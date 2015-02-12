<?php
        
            function findClass($class) {
                $class = str_replace('\\', '/', $class) . '.php';
                if (file_exists($class)) {
                    require_once "$class";
                }
            }

            spl_autoload_register('findClass');

            use controller\FrontController;
            
            $front = new FrontController();
            $front->start();
            //Hello!