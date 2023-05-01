<?php

    include(__DIR__."/../include/ClientsCommandsIndex_src.php");
    include(__DIR__."/../include/addClientProduct_src.php");

    $client = getAllClients($pdo);
    $product = getAllProducts($pdo);
    $order = getAllOrders($pdo);

    echo <<<HTML

        <header class="bg-white shadow">

            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">Dashboard</h1>
            </div>

        </header>

        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 shadow-lg border-sky-500 rounded-md my-8">
            <header>

                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">Clients</h1>
                </div>

            </header>

            <ul role="list" class="divide-y divide-gray-100">
                
        HTML;

        for ($i=0; $i < count($client); $i++) {

            $random = rand(0, 5);

            echo <<<HTML
                <div class="lts">
                    <li class="flex justify-between gap-x-6 py-5">
                        <div class="flex gap-x-4">
                        <img class="h-12 w-12 flex-none rounded-full bg-gray-50" src="https://picsum.photos/200/30{$random}" alt="">
                        <div class="min-w-0 flex-auto">
                            <p class="text-sm font-semibold leading-6 text-gray-900">{$client[$i][1]} {$client[$i][2]} </p>
                            <p class="mt-1 truncate text-xs leading-5 text-gray-500">{$client[$i][3]}</p>
                        </div>
                        </div>
                        <div class="hidden sm:flex sm:flex-col sm:items-end">
                        <p class="text-sm leading-6 text-gray-900">Client</p>
                        <p class="mt-1 text-xs leading-5 text-gray-500">{$client[$i][5]} {$client[$i][4]}</p>
                        </div>
                    </li>

                    <ul role="list" class="divide-y divide-gray-100 mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

            HTML;

            for ($j=0 ; $j < count($order); $j++) {

                if ($client[$i][0] == $order[$j][1]) {

                    echo <<<HTML
                    
                        <li class="flex justify-between gap-x-6 py-5">
                            <div class="flex gap-x-4">
                            <img class="h-12 w-12 flex-none rounded-full bg-gray-50" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTaeLJIVehBMLODpTzVuf8OMeDoP9gx4ZVqKXthXk56LDQToZUAv5TkuJvtDFlqHNoZkYU&usqp=CAU" alt="">
                            <div class="min-w-0 flex-auto">

                    HTML;

                    for ($k=0; $k < count($product); $k++) {
                                    
                        if ($product[$k][0] == $order[$j][4]) {

                            $name = $product[$k][2];
                            break;

                        }

                    }

                    echo <<<HTML

                                <p class="text-sm font-semibold leading-6 text-gray-900">{$name}</p>
                                <p class="mt-1 truncate text-xs leading-5 text-gray-500">{$order[$j][3]}</p>
                            </div>
                            </div>
                            <div class="hidden sm:flex sm:flex-col sm:items-end">
                            <p class="text-sm leading-6 text-gray-900">Quantité : {$order[$j][5]}</p>
                            <p class="mt-1 text-xs leading-5 text-gray-500">{$order[$j][2]}</p>
                            </div>
                        </li>

                    HTML;

                }
            }

            echo <<<HTML

                    </ul>
                </div>

            HTML;
        
        }

        echo <<<HTML
            
            </ul>
        </div>

        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 shadow-lg border-sky-500 rounded-md mb-8">
            <header>

                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">Articles</h1>
                </div>

            </header>

            <ul role="list" class="divide-y divide-gray-100">

        HTML;

        for ($i=0; $i < count($product); $i++) {

            echo <<<HTML
            
                    <li class="flex justify-between gap-x-6 py-5">
                        <div class="flex gap-x-4">
                        <img class="h-12 w-12 flex-none rounded-full bg-gray-50" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTaeLJIVehBMLODpTzVuf8OMeDoP9gx4ZVqKXthXk56LDQToZUAv5TkuJvtDFlqHNoZkYU&usqp=CAU" alt="">
                        <div class="min-w-0 flex-auto">
                            <p class="text-sm font-semibold leading-6 text-gray-900">{$product[$i][2]}</p>
                            <p class="mt-1 truncate text-xs leading-5 text-gray-500">Code : {$product[$i][1]}</p>
                        </div>
                        </div>
                        <div class="hidden sm:flex sm:flex-col sm:items-end">
                        <p class="text-sm leading-6 text-gray-900">{$product[$i][3]}€</p>
                        </div>
                    </li>

            HTML;

        }

        echo <<<HTML

            </ul>
        </div>

    HTML;
?>