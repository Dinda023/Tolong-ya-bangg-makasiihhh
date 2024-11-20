@extends('layouts.admin')

@section('content')
@can('event_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('events.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.event.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<h3 class="page-title">{{ trans('global.systemCalendar') }}</h3>

<div class="card">
    <div class="card-header">
        {{ trans('global.systemCalendar') }}
    </div>

    <div class="card-body">
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />
        <div id='calendar'></div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        // Ambil data events dari backend
        let events = {!! json_encode($events) !!};

        // Validasi dan map events untuk FullCalendar
        events = events.filter(event => {
            const startTime = moment(event.start);
            const endTime = moment(event.end);

            // Cek jika start_time lebih lama dari end_time
            if (startTime.isAfter(endTime)) {
                // Tampilkan peringatan menggunakan SweetAlert
                Swal.fire({
                    title: 'Invalid Event Time',
                    text: `Event '${event.name}' has an invalid time range. Start time cannot be later than end time.`,
                    icon: 'warning',
                    confirmButtonText: 'Close',
                });

                return false; // Abaikan event ini dari FullCalendar
            }
            return true; // Valid event
        });

        // Inisialisasi FullCalendar
        $('#calendar').fullCalendar({
            events: events.map(event => ({
                title: event.name,
                start: event.start,  // pastikan ini sudah dalam format ISO 8601
                end: event.end,      // pastikan ini sudah dalam format ISO 8601
                id: event.id,
                photo: event.photo,
                location: event.location // Add the location here
            })),
            eventClick: function (event, jsEvent, view) {
                // Prevent default action
                jsEvent.preventDefault();

                // Format start_time dan end_time untuk ditampilkan dengan lebih baik
                const startTime = moment(event.start).format('YYYY-MM-DD HH:mm:ss');
                const endTime = moment(event.end).format('YYYY-MM-DD HH:mm:ss');

                // Build event details content including location
                const detailsHtml = `
                    <div>
                        <h4>${event.title}</h4>
                        <p><strong>Start Time:</strong> ${startTime}</p>
                        <p><strong>End Time:</strong> ${endTime}</p>
                        <p><strong>Location:</strong> ${event.location || 'No location provided'}</p> <!-- Display location -->
                        ${
                            event.photo 
                            ? `<p><strong>Photo:</strong><br><img src="{{ asset('storage') }}/${event.photo}" alt="Event Photo" style="max-width: 100%; height: auto;"></p>`
                            : '<p><strong>Photo:</strong> No photo available</p>'
                        }
                    </div>
                `;

                // Show popup with SweetAlert
                Swal.fire({
                    title: 'Event Details',
                    html: detailsHtml,
                    icon: 'info',
                    confirmButtonText: 'Close',
                });
            }
        });
    });
</script>
@stop
