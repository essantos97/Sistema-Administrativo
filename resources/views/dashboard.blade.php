<x-app-layout>
   
    <x-slot name="header">
    
        <div class="flex">
            <div class="w-1/6 bg-none h-12">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Bem vindo ')}}{{auth()->user()->name }}
                </h2>
            </div>

            
            <div class="w-1/6 bg-none h-12"></div>
            
            <div class="w-1/6 bg-none h-12"></div>
            <div class="w-1/6 bg-none h-12">
                <a href="{{route('admin.saque')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">Realizar Saque</a>        
            </div>
            <div class="w-1/6 bg-none h-12">
                <a href="{{route('admin.adicionar.conta')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">Adicionar Conta</a>        
            </div>
            <div class="w-1/6 bg-none h-12">
                <a href="{{route('admin.verificar.conta')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">Verificar Conta</a>        
            </div>
        </div>     
    </x-slot>


<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="w-1/6 bg-none h-12">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Sua empresa: ')}}
                    </h2>
                </div>
                <table class="table" width="1000px">                                                                                                                                                                                          
                    <tr>                                                                               
                        <th>Nome Fantasia</th>                              
                        <th>CNPJ  </th>
                        <th>Saldo </th>  
                        <th>Email </th>  
                        <th>Telefone </th>                                                                                                           
                    </tr>                                                                                          
                        <tr>                            
                            <td>{{$empresas->nomeFantasia}}</td>
                            <td>{{$empresas->cnpj}}</td>
                            <td>R$ {{$empresas->saldo_empresa}}</td> 
                            <td>{{$empresas->email}}</td>
                            <td>{{$empresas->telefone}}</td>
                                                 
                        </tr>                                                                                                                                                                       
                </table>                
                
            </div>
        </div>
    </div>
</div>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="w-1/6 bg-none h-12">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Suas Contas: ')}}
                    </h2>
                </div>
                <table class="table" width="500px">                                                                                                                                                                                          
                    <tr>                                                                               
                        <th>Proprietario</th>                              
                        <th>N??mero  </th>  
                        <th>Verificada</th>                                                    
                    </tr>                                                                                          
                        
                    @if (!empty($contas))
                        @foreach ($contas as $conta)
                        <tr>  
                            <td>{{$conta->proprietario}} <br></td>
                            <td>{{$conta->num_conta}}</td> 
                            @if ($conta->verificada == 0)
                                <td>N??O</td> 
                            @else
                                <td>SIM</td>  
                            @endif
                        </tr>                                                    
                        @endforeach                                                                           
                    @endif                                    
                                                                                                                                                                                                                                                                                                             
                </table>
                                
            </div>
        </div>
    </div>
</div>
</x-app-layout>
