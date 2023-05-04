<?php

    echo <<<HTML

        <img class="h-full" src="content/img/iut.png" alt="Logo de notre magasin">

        <nav class="h-full flex items-center gap-20">
            <button class="px-4 py-2 flex items-center gap-4 bg-zinc-800 rounded-[20px] text-white">
                <i class="fa-solid fa-house"></i>
                <span>Dashboard</span>
            </button>
            <button class="aspect-square p-2 flex justify-center items-center rounded-[20px] text-slate-400"><i class="fa-solid fa-address-book"></i></button>
            <button class="aspect-square p-2 flex justify-center items-center rounded-[20px] text-slate-400"><i class="fa-solid fa-box-open"></i></button>
         </nav>

        <nav class="h-full flex items-center gap-5">
            <img src="https://images.pexels.com/photos/2599869/pexels-photo-2599869.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="" class="h-full aspect-square bg-slate-400 border-2 border-slate-400 rounded-full">
            <div class="flex flex-col">
                <span class="text-white">{$_SESSION['user-name']}</span>
                <span class="text-slate-400">{$_SESSION['user-mail']}</span>
            </div>
            <button class="aspect-square p-2 flex justify-center items-center rounded-[20px] text-white" onclick="window.location.href = '?disconnect'"><i class="fa-solid fa-arrow-right-from-bracket"></i></button>
        </nav>

    HTML;
  











  









// echo <<<HTML

//   <nav class="bg-gray-800">

//     <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">

//       <div class="relative flex h-16 items-center justify-between">

//         <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">

//           <!-- Mobile menu button-->
//           <button type="button" class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
//             <span class="sr-only">Ouvrir le menu</span>
//             <!--
//               Icon when menu is closed.

//               Menu open: "hidden", Menu closed: "block"
//             -->
//             <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
//               <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
//             </svg>
//             <!--
//               Icon when menu is open.

//               Menu open: "block", Menu closed: "hidden"
//             -->
//             <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
//               <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
//             </svg>
//           </button>

//         </div>

//         <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">

//           <div class="flex flex-shrink-0 items-center">

//               <script>

//               function reloadtomain() {

//                   window.location = window.location.href.split("?")[0];
              
//               }

//               </script>

//               <a onclick="reloadtomain()" class="hover:cursor-pointer">
              
//                   <img class="h-10 w-25 hover:cursor_pointer" src="content/img/iut.png" alt="Logo de notre magasin">

//               </a>

//           </div>

//           <div class="hidden sm:ml-6 sm:block">

//             <div class="flex space-x-4">

//               <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
//               <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Dashboard</a>

//               <a href="#" data-dropdown-toggle="addtodb" data-dropdown-trigger="hover" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Ajouter un élément</a>
//               <div id="addtodb" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
//                 <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton">
//                   <li>
//                       <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Ajouter un client</a>
//                   </li>
//                   <li>
//                       <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Ajouter un produit</a>
//                   </li>
//                   <li>
//                       <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Ajouter une commande</a>
//                   </li>
//                 </ul>
//               </div>

              
//               <a href="#" data-dropdown-toggle="rmfromdb" data-dropdown-trigger="hover" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Supprimer un élément</a>
//               <div id="rmfromdb" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
//                 <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton">
//                   <li>
//                       <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Supprimer un client</a>
//                   </li>
//                   <li>
//                       <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Supprimer un produit</a>
//                   </li>
//                   <li>
//                       <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Supprimer une commande</a>
//                   </li>
//                 </ul>
//               </div>

//             </div>

//           </div>

//         </div>

//         <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">

          

//             <p class="text-gray-400">Connecté en tant que "NOM" </p>

//           <!-- Profile dropdown -->
//           <div class="relative ml-3">

//             <div>

//               <button type="button" class="flex rounded-md bg-gray-800 text-sm hover:bg-red-800" id="user-menu-button">
//                 <span class="sr-only">Open user menu</span>
//                 <img class="h-7 w-7 rounded-md" src="content/img/logout.png" alt="Se déconnecter" title="Se déconnecter">
//               </button>

//             </div>

//           </div>

//         </div>

//       </div>

//     </div>

//     <!-- Mobile menu, show/hide based on menu state. -->
//     <div class="sm:hidden" id="mobile-menu">

//       <div class="space-y-1 px-2 pb-3 pt-2">

//         <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
//         <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Dashboard</a>
//         <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Ajouter un client</a>
//         <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Ajouter un produit</a>
//         <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Commander un produit</a>
//       </div>
//     </div>
//   </nav>

// HTML;

?>