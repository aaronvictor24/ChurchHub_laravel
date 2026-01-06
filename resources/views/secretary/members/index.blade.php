@extends('layouts.secretary')

@section('content')
    <x-table.member-table :members="$members" />
@endsection
