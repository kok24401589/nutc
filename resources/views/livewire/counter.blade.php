<head>
   
    @livewireStyles
</head>
<body>
    <livewire:counter /> 
 
 <div style="text-align: center">
    <button wire:click="increment">+</button>
    <h1>{{ $count }}</h1>
</div>
    @livewireScripts
</body>
</html>
