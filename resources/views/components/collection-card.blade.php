@props(['collections'])

<x-card>
    <div class="flex">
        <div>
            <h3 class="text-2xl">
                <a href="/CollectionViewInfo/{{$collections->id}}">{{$collections->name}}</a>
            </h3>
            <div class="text-xl font-bold mb-4">{{$collections->description}}</div>
            <div class="text-xlmb-4">{{$collections->creation_date}}</div>
        </div>
    </div>
</x-card>