@auth

    @role('owner')
        <x-sidebar.owner />
    @endrole

    @role('mandor')
        <x-sidebar.mandor />
    @endrole

    @role('pekerja')
        <x-sidebar.worker />
    @endrole

@endauth