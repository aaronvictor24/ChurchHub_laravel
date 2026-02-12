@extends('layouts.secretary')

@section('content')
    <style>
        @media print {
            * {
                margin: 0;
                padding: 0;
            }

            body {
                background: white;
                color: black;
                font-family: Arial, sans-serif;
                line-height: 1.4;
            }

            .no-print {
                display: none !important;
            }

            /* Print Header Styles */
            .print-header {
                display: block !important;
                text-align: center;
                border-bottom: 3px solid #000;
                padding-bottom: 20px;
                margin-bottom: 30px;
                page-break-after: avoid;
            }

            .print-header-top {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 20px;
                margin-bottom: 15px;
            }

            .print-logo {
                width: 70px;
                height: 70px;
                display: flex;
                align-items: center;
            }

            .print-logo img {
                width: 100%;
                height: 100%;
                object-fit: contain;
            }

            .print-header-text {
                text-align: center;
            }

            .print-title {
                font-size: 24px;
                font-weight: bold;
                margin: 5px 0;
                letter-spacing: 0.5px;
            }

            .print-subtitle {
                font-size: 14px;
                margin: 3px 0;
                color: #333;
            }

            /* Calendar Styles */
            #calendar {
                height: auto !important;
                min-height: auto !important;
                max-height: none !important;
                page-break-inside: avoid;
            }

            .fc {
                background: white !important;
                color: black !important;
            }

            .fc-button-primary {
                display: none !important;
            }

            .fc .fc-toolbar {
                background: white !important;
                color: black !important;
                border-bottom: 2px solid #000 !important;
                margin: 20px 0 !important;
                padding: 15px 0 !important;
            }

            .fc .fc-toolbar-title {
                font-size: 20px !important;
                font-weight: bold !important;
                color: black !important;
            }

            .fc .fc-button {
                display: none !important;
            }

            .fc .fc-button.fc-button-primary {
                display: none !important;
            }

            .fc-button-group,
            .fc-button.fc-button-primary:not(:disabled).fc-button-active,
            button.fc-button.fc-button-primary {
                display: none !important;
            }

            /* Day Grid Styles */
            .fc .fc-daygrid {
                border: 1px solid #000 !important;
            }

            .fc .fc-daygrid-day {
                border: 1px solid #999 !important;
                height: 100px !important;
                page-break-inside: avoid;
            }

            .fc .fc-daygrid-day-frame {
                height: 100% !important;
            }

            .fc .fc-col-header {
                background-color: #e5e7eb !important;
                border: 1px solid #000 !important;
                padding: 12px 0 !important;
            }

            .fc .fc-col-header-cell {
                font-weight: bold !important;
                color: black !important;
                font-size: 14px !important;
            }

            .fc .fc-daygrid-day-number {
                color: black !important;
                padding: 8px !important;
                font-weight: 600 !important;
            }

            /* Event Styles */
            .fc .fc-daygrid-day-events {
                margin: 4px !important;
            }

            .fc-event {
                background-color: #3b82f6 !important;
                border-color: #1e40af !important;
                border: 1px solid #1e40af !important;
                color: white !important;
                font-size: 11px !important;
                padding: 2px 4px !important;
                margin: 2px 0 !important;
                page-break-inside: avoid;
            }

            .fc-event-title {
                font-weight: 600 !important;
                color: white !important;
                font-size: 11px !important;
            }

            .fc-event-time {
                font-size: 10px !important;
                color: white !important;
            }

            /* Different event colors (if needed) */
            .fc-event {
                background-color: #60a5fa !important;
                border-color: #2563eb !important;
            }

            /* Other day styles */
            .fc .fc-daygrid-day.fc-day-other {
                background-color: #f9fafb !important;
            }

            .fc .fc-daygrid-day.fc-day-today {
                background-color: #fef3c7 !important;
            }

            /* Ensure proper page breaks */
            @page {
                margin: 10mm;
            }

            /* Remove table cell styling issues */
            .fc table {
                border-collapse: collapse !important;
            }

            .fc th,
            .fc td {
                border: 1px solid #999 !important;
            }
        }

        .print-header {
            display: none;
        }

        .print-button {
            display: inline-block;
            margin-right: 10px;
        }
    </style>

    <div class="space-y-6 container mx-auto p-6 text-gray-100 bg-gray-900 min-h-screen">
        <!-- Print Header -->
        <div class="print-header">
            <div class="print-header-top">
                <div class="print-logo">
                    @if (Auth::user() && Auth::user()->secretary && Auth::user()->secretary->church)
                        <img src="{{ asset('images/logo.png') }}" alt="Church Logo">
                    @endif
                </div>
                <div class="print-header-text">
                    <h2 class="print-title">Event Calendar</h2>
                    @if (Auth::user() && Auth::user()->secretary && Auth::user()->secretary->church)
                        <p class="print-subtitle">{{ Auth::user()->secretary->church->name }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center mb-4 no-print">
            <h1 class="text-2xl font-bold text-white"> Event Calendar</h1>
            <button onclick="window.print()"
                class="rounded-md bg-gray-600 hover:bg-gray-500 px-6 py-2.5 text-white font-medium transition print-button">Print</button>
        </div>

        <x-secretary.calendar :calendarEvents="$calendarEvents" />
    </div>
@endsection
