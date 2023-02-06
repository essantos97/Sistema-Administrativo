<x-empresa-layout>
    <x-slot name="header">


        <div class="flex">
            <div class="w-1/6 bg-none h-12">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('EMPRESA') }}
                </h2>
            </div>

            <div class="w-1/6 bg-none h-12"></div>
            <div class="w-1/6 bg-none h-12"></div>
            
            <div class="w-1/6 bg-none h-12"></div>
            <div class="w-1/6 bg-none h-12">
                <a href="{{route('empresa.venda')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">Realizar venda</a>        
            </div>
            <div class="w-1/6 bg-none h-12">
                <a href="{{route('register')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">Cadastrar Admin</a>        
            </div>
          </div>     
        
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="w-1/6 bg-none h-12">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ __('Administrador: ')}}
                        </h2>
                    </div>
                    <table class="table" width="600px">                                                                                                                                                                                          
                        <tr>                                                                               
                            <th>Nome</th>                              
                            <th>CPF  </th>                            
                            <th>Email </th>                                                                                                                                     
                        </tr>                                                                                          
                            <tr>  
                                @if (auth()->guard('empresa')->user()->cpf_admin != null)
                                    <td>{{$admin['name']}}</td>
                                    <td>{{$admin->cpf}}</td>                                
                                    <td>{{$admin->email}}</td> 
                                               
                                @endif                                    
                                                                                                                    
                            </tr>                                                                                                                                                                       
                    </table>
                    
                    
                </div>
            </div>
        </div>
    </div>
</x-empresa-layout>
