@php

$projects = [

    [
        'id' => 1,
        'name' => 'Jakarta Sky Tower',
        'client' => 'PT Jakarta Properti',
        'status' => 'Active',
        'start_date' => '12 Oct 2025',
        'phase' => 'Structural Work',
        'progress' => 64,
        'last_update' => '2 hours ago',
    ],

    [
        'id' => 2,
        'name' => 'Green Valley Residence',
        'client' => 'PT Green Valley',
        'status' => 'Active',
        'start_date' => '05 Jan 2026',
        'phase' => 'Foundation',
        'progress' => 38,
        'last_update' => '5 hours ago',
    ],

    [
        'id' => 3,
        'name' => 'Citra Business Center',
        'client' => 'PT Citra Development',
        'status' => 'On Hold',
        'start_date' => '20 Feb 2026',
        'phase' => 'Finishing',
        'progress' => 82,
        'last_update' => 'Yesterday',
    ],

];

@endphp


<div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">

    @foreach($projects as $project)

        <x-mandor.projects.project-card
            :project="$project"
        />

    @endforeach

</div>