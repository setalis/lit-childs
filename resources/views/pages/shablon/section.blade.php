@extends('layouts.app')
@section('title', 'Зміст підручника - Schoolbook')
@section('content')
<div class="flex flex-col items-center justify-center border-b border-yellow-500 mb-8">
    <div class="container flex flex-col md:flex-row mx-auto lg:px-8 px-4 py-8">
        <div class="w-3/4 flex flex-col justify-center">
            <h1 class="text-4xl font-bold mb-4 uppercase text-[#28569A]">Розділ 1</h1>
            <h2 class="text-3xl font-bold mb-4 uppercase">ЛІТЕРАТУРОЗНАВЧІ ЗАСАДИ МЕТОДИКИ НАВЧАННЯ ЧИТАННЯ В ПОЧАТКОВІЙ ШКОЛІ
            </h2>
        </div>
        <div class="w-1/4 flex flex-col items-center justify-center">
            <div class="flex flex-col items-center justify-center">
                <img src="{{ asset('storage/header-1.png') }}" alt="Section 1" class="w-full h-auto">
            </div>
        </div>
    </div>
</div>
<div class="flex flex-col items-center justify-center">
    <div class="container flex flex-col mx-auto lg:px-8 px-4 py-8">
        <div class="w-3/4 flex flex-col justify-center mb-4 ">
            <h1 class="text-3xl mb-4 text-[#28569A] font-semibold">Тематичний контент</h1>
            </h1>
        </div>
        <div class="mb-4">
            <div class="flex md:flex-row flex-col items-center mb-4">
                <p class="text-2xl bg-yellow-500 p-3 mr-4 w-[50px] h-[50px] rounded-2xl flex items-center justify-center">1.1</p>
                <p class="text-2xl">Художня література як вид мистецтва</p>            
            </div>
            <ol class="ml-16">
                    <li class="flex flex-col mb-4">
                        <div class="flex flex-row mb-4">
                            <div class="icon  mr-4 rounded-lg border w-[36px] h-[36px] border-yellow-500 flex items-center justify-center text-yellow-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            </div>
                            <p class="text-xl">Теоретичний матеріал</p>
                        </div>
                        
                    </li>                    
                    <li class="flex flex-col mb-4">
                        <div class="flex flex-row mb-4">
                            <div class="icon mr-4 rounded-lg border w-[36px] h-[36px] border-yellow-500 flex items-center justify-center text-yellow-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            </div>
                            <p class="text-xl">Практичні завдання</p>
                        </div>
                        <ol class="ml-14">
                            <li class="flex flex-row items-center mb-4">
                                <div class="icon  mr-4 rounded-lg border w-[36px] h-[36px] border-[#28569A] flex items-center justify-center text-yellow-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#28569A" class="bi bi-pin-angle-fill" viewBox="0 0 16 16">
                                    <path d="M9.828.722a.5.5 0 0 1 .354.146l4.95 4.95a.5.5 0 0 1 0 .707c-.48.48-1.072.588-1.503.588-.177 0-.335-.018-.46-.039l-3.134 3.134a6 6 0 0 1 .16 1.013c.046.702-.032 1.687-.72 2.375a.5.5 0 0 1-.707 0l-2.829-2.828-3.182 3.182c-.195.195-1.219.902-1.414.707s.512-1.22.707-1.414l3.182-3.182-2.828-2.829a.5.5 0 0 1 0-.707c.688-.688 1.673-.767 2.375-.72a6 6 0 0 1 1.013.16l3.134-3.133a3 3 0 0 1-.04-.461c0-.43.108-1.022.589-1.503a.5.5 0 0 1 .353-.146"/>
                                    </svg>
                                </div>
                                <p class="text-lg">Репродуктивний рівень</p>
                            </li>
                            <li class="flex flex-row items-center mb-4">
                                <div class="icon  mr-4 rounded-lg border w-[36px] h-[36px] border-[#28569A] flex items-center justify-center text-yellow-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#28569A" class="bi bi-pin-angle-fill" viewBox="0 0 16 16">
                                    <path d="M9.828.722a.5.5 0 0 1 .354.146l4.95 4.95a.5.5 0 0 1 0 .707c-.48.48-1.072.588-1.503.588-.177 0-.335-.018-.46-.039l-3.134 3.134a6 6 0 0 1 .16 1.013c.046.702-.032 1.687-.72 2.375a.5.5 0 0 1-.707 0l-2.829-2.828-3.182 3.182c-.195.195-1.219.902-1.414.707s.512-1.22.707-1.414l3.182-3.182-2.828-2.829a.5.5 0 0 1 0-.707c.688-.688 1.673-.767 2.375-.72a6 6 0 0 1 1.013.16l3.134-3.133a3 3 0 0 1-.04-.461c0-.43.108-1.022.589-1.503a.5.5 0 0 1 .353-.146"/>
                                    </svg>
                                </div>
                                <p class="text-lg">Конструктивний рівень</p>
                            </li>
                            <li class="flex flex-row items-center mb-4">
                                <div class="icon  mr-4 rounded-lg border w-[36px] h-[36px] border-[#28569A] flex items-center justify-center text-yellow-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#28569A" class="bi bi-pin-angle-fill" viewBox="0 0 16 16">
                                    <path d="M9.828.722a.5.5 0 0 1 .354.146l4.95 4.95a.5.5 0 0 1 0 .707c-.48.48-1.072.588-1.503.588-.177 0-.335-.018-.46-.039l-3.134 3.134a6 6 0 0 1 .16 1.013c.046.702-.032 1.687-.72 2.375a.5.5 0 0 1-.707 0l-2.829-2.828-3.182 3.182c-.195.195-1.219.902-1.414.707s.512-1.22.707-1.414l3.182-3.182-2.828-2.829a.5.5 0 0 1 0-.707c.688-.688 1.673-.767 2.375-.72a6 6 0 0 1 1.013.16l3.134-3.133a3 3 0 0 1-.04-.461c0-.43.108-1.022.589-1.503a.5.5 0 0 1 .353-.146"/>
                                    </svg>
                                </div>
                                <p class="text-lg">Творчий рівень</p>
                            </li>
                        </ol>      
                    </li>
                    <li class="flex flex-col">
                        <div class="flex flex-row mb-4">
                            <div class="icon  mr-4 rounded-lg border w-[36px] h-[36px] border-yellow-500 flex items-center justify-center text-yellow-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                        </div>
                        <p class="text-xl">Завдання для самостійної роботи</p>
                        </div>
                                              
                    </li>
                    <li class="flex flex-col mb-4">
                        <div class="flex flex-row mb-4">
                            <div class="icon  mr-4 rounded-lg border w-[36px] h-[36px] border-yellow-500 flex items-center justify-center text-yellow-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            </div>
                            <p class="text-xl">Засоби контролю</p>
                        </div>
                        <ol class="ml-14">
                            <li class="flex flex-row items-center mb-4">
                                <div class="icon  mr-4 rounded-lg border w-[36px] h-[36px] border-[#28569A] flex items-center justify-center text-yellow-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#28569A" class="bi bi-pin-angle-fill" viewBox="0 0 16 16">
                                    <path d="M9.828.722a.5.5 0 0 1 .354.146l4.95 4.95a.5.5 0 0 1 0 .707c-.48.48-1.072.588-1.503.588-.177 0-.335-.018-.46-.039l-3.134 3.134a6 6 0 0 1 .16 1.013c.046.702-.032 1.687-.72 2.375a.5.5 0 0 1-.707 0l-2.829-2.828-3.182 3.182c-.195.195-1.219.902-1.414.707s.512-1.22.707-1.414l3.182-3.182-2.828-2.829a.5.5 0 0 1 0-.707c.688-.688 1.673-.767 2.375-.72a6 6 0 0 1 1.013.16l3.134-3.133a3 3 0 0 1-.04-.461c0-.43.108-1.022.589-1.503a.5.5 0 0 1 .353-.146"/>
                                    </svg>
                                </div>
                                <p class="text-lg">Питання та завдання для самоперевірки</p>
                            </li>
                            <li class="flex flex-row items-center mb-4">
                                <div class="icon  mr-4 rounded-lg border w-[36px] h-[36px] border-[#28569A] flex items-center justify-center text-yellow-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#28569A" class="bi bi-pin-angle-fill" viewBox="0 0 16 16">
                                    <path d="M9.828.722a.5.5 0 0 1 .354.146l4.95 4.95a.5.5 0 0 1 0 .707c-.48.48-1.072.588-1.503.588-.177 0-.335-.018-.46-.039l-3.134 3.134a6 6 0 0 1 .16 1.013c.046.702-.032 1.687-.72 2.375a.5.5 0 0 1-.707 0l-2.829-2.828-3.182 3.182c-.195.195-1.219.902-1.414.707s.512-1.22.707-1.414l3.182-3.182-2.828-2.829a.5.5 0 0 1 0-.707c.688-.688 1.673-.767 2.375-.72a6 6 0 0 1 1.013.16l3.134-3.133a3 3 0 0 1-.04-.461c0-.43.108-1.022.589-1.503a.5.5 0 0 1 .353-.146"/>
                                    </svg>
                                </div>
                                <p class="text-lg">Тестові завдання</p>
                            </li>
                        </ol>                        
                    </li>
            </ol>    
        </div>
        <div class="mb-4">
            <div class="flex md:flex-row flex-col items-center mb-4">
                <p class="text-2xl bg-yellow-500 p-3 mr-4 w-[50px] h-[50px] rounded-2xl flex items-center justify-center">1.2</p>
                <p class="text-2xl">Дитяча література: сутність та особливості</p>            
            </div>            
        </div>   
        <div class="mb-4">
            <div class="flex md:flex-row flex-col items-center mb-4">
                <p class="text-2xl bg-yellow-500 p-3 mr-4 w-[50px] h-[50px] rounded-2xl flex items-center justify-center">1.3</p>
                <p class="text-2xl">Діалектична єдність змісту і форми художнього твору</p>            
            </div>            
        </div>       
        <div class="mb-4">
            <div class="flex md:flex-row flex-col items-center mb-4">
                <p class="text-2xl bg-yellow-500 p-3 mr-4 w-[50px] h-[50px] rounded-2xl flex items-center justify-center">1.4</p>
                <p class="text-2xl">Змістові компоненти та сюжетно-композиційна будова художнього твору </p>            
            </div>            
        </div>   
        <div class="mb-4">
            <div class="flex md:flex-row flex-col items-center mb-4">
                <p class="text-2xl bg-yellow-500 p-3 mr-4 w-[50px] h-[50px] rounded-2xl flex items-center justify-center">1.5</p>
                <p class="text-2xl">Художні засоби літературного твору та системи віршування</p>            
            </div>            
        </div>
        <div class="mb-4">
            <div class="flex md:flex-row flex-col items-center mb-4">
                <p class="text-2xl bg-yellow-500 p-3 mr-4 w-[50px] h-[50px] rounded-2xl flex items-center justify-center">1.6</p>
                <p class="text-2xl">Родово-жанровий поділ художньої літератури</p>            
            </div>            
        </div>   
        <div class="mb-4">
            <div class="flex md:flex-row flex-col items-center mb-4">
                <p class="text-2xl bg-yellow-500 p-3 mr-4 w-[50px] h-[50px] rounded-2xl flex items-center justify-center">1.7</p>
                <p class="text-2xl">Аналіз художнього твору</p>            
            </div>            
        </div>       
        <div class="mb-4">
            <div class="flex md:flex-row flex-col items-center mb-4">
                <p class="text-2xl bg-yellow-500 p-3 mr-4 w-[50px] h-[50px] rounded-2xl flex items-center justify-center">1.8</p>
                <p class="text-2xl">Літературознавча пропедевтика в початкових класах</p>            
            </div>            
        </div>   
                
    </div>

    <!-- описа розділу -->
    <div class="container flex flex-col mx-auto lg:px-8 px-4 py-2 mb-8">
        <div class="w-3/4 flex flex-col justify-center mb-4 ">
            <h1 class="text-3xl mb-4 text-[#28569A] font-semibold">Очікувані результати навчання</h1>
            </h1>
        </div>
        <div class="flex flex-row items-center mb-2">
            <div class="mr-5">
                <h2 class="text-xl font-semibold bg-[#94BDDD] text-white p-3 w-[50px] h-[50px] rounded-2xl flex items-center justify-center">1</h2>
            </div>
            <div class="grow-1">
                <h2 class="text-xl">Пояснювати сутність поняття “література” як виду мистецтва.</h2>                
            </div>
        </div>
        <div class="flex flex-row items-center mb-2">
            <div class="mr-5">
                <h2 class="text-xl font-semibold bg-[#94BDDD] text-white p-3 w-[50px] h-[50px] rounded-2xl flex items-center justify-center">2</h2>
            </div>
            <div class="grow-1">
                <h2 class="text-xl">Визначати об’єкт зображення, предмет зображення і предмет пізнання в художніх творах.</h2>                
            </div>
        </div>
        <div class="flex flex-row items-center mb-2">
            <div class="mr-5">
                <h2 class="text-xl font-semibold bg-[#94BDDD] text-white p-3 w-[50px] h-[50px] rounded-2xl flex items-center justify-center">3</h2>
            </div>
            <div class="grow-1">
                <h2 class="text-xl">Відрізняти і характеризувати ознаки художніх та інформаційних текстів.</h2>                
            </div>
        </div>
        <div class="flex flex-row items-center mb-3">
            <div class="mr-5">
                <h2 class="text-xl font-semibold bg-[#94BDDD] text-white p-3 w-[50px] h-[50px] rounded-2xl flex items-center justify-center">4</h2>
            </div>
            <div class="grow-1">
                <h2 class="text-xl">Характеризувати сутність, особливості та функції дитячої літератури.</h2>                
            </div>
        </div>
        <div class="flex flex-row items-center mb-3">
            <div class="mr-5">
                <h2 class="text-xl font-semibold bg-[#94BDDD] text-white p-3 w-[50px] h-[50px] rounded-2xl flex items-center justify-center">5</h2>
            </div>
            <div class="grow-1">
                <h2 class="text-xl">Визначати функції творів дитячої літератури.</h2>                
            </div>
        </div>
        <div class="flex flex-row items-center mb-3">
            <div class="mr-5">
                <h2 class="text-xl font-semibold bg-[#94BDDD] text-white p-3 w-[50px] h-[50px] rounded-2xl flex items-center justify-center">6</h2>
            </div>
            <div class="grow-1">
                <h2 class="text-xl">Знати коло сучасних українських дитячих письменників та  літературної періодики для дітей, проводити критичний аналіз видань.</h2>                
            </div>
        </div>
        <div class="flex flex-row items-center mb-3">
            <div class="mr-5">
                <h2 class="text-xl font-semibold bg-[#94BDDD] text-white p-3 w-[50px] h-[50px] rounded-2xl flex items-center justify-center">7</h2>
            </div>
            <div class="grow-1">
                <h2 class="text-xl">Пояснювати діалектичну єдність змісту і форми. Наводити приклади.</h2>                
            </div>
        </div>
        <div class="flex flex-row items-center mb-3">
            <div class="mr-5">
                <h2 class="text-xl font-semibold bg-[#94BDDD] text-white p-3 w-[50px] h-[50px] rounded-2xl flex items-center justify-center">8</h2>
            </div>
            <div class="grow-1">
                <h2 class="text-xl">Розробляти зміст евристичної бесіди для ознайомлення здобувачів початкової освіти з літературними поняттями, явищами, прикладами.</h2>                
            </div>
        </div>
    </div>    
</div>
@endsection