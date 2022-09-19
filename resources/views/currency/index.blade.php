@extends('layouts.app')

@section('content')
<div class="container">

    <div class="py-12">


        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead>
                <tr class="odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"> Id</th>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"> User</th>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">Currency</th>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">Rate</th>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">Date</th>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($exchange_rates as $exchange_rate)
                <tr class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                    <td class="px-6 py-4">{{ $exchange_rate->id }}</td>
                    <td class="px-6 py-4">{{ $exchange_rate->user->name }}</td>
                    <td class="px-6 py-4">{{ $exchange_rate->currencyRates->date }}</td>
                    <td class="px-6 py-4">{{ $exchange_rate->currencyRates->currency }}</td>
                    <td class="px-6 py-4">{{ $exchange_rate->currencyRates->rate }}</td>
                    <td class="px-6 py-4">
                        
                    <form action="{{ route('currency.destroy', $exchange_rate->id)}}" method="POST">
                            @csrf
                            @method("DELETE")
                            <button value="submit" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                       
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
      

        <div class="mt-4">
        {{ $exchange_rates->links() }}
        </div>
        </div>
    </div>

</div>    
@endsection
