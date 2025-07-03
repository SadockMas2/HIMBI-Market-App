@php
    use Illuminate\Support\Facades\Auth;
@endphp


<div class="container-fluid has-bg-overlay text-center text-light has-height-lg middle-items" id="book-table">
        <div class="">
            <h2 class="section-title mb-5">TROUVER UNE TABLE</h2>

                <form action="{{ url('book_table')}}" method="POST">
    @csrf

    <div class="row mb-5">

        @if(Auth::check())
            <div class="col-sm-6 col-md-3 col-xs-12 my-2">
                <input type="text" class="form-control form-control-lg custom-form-control" 
                       value="{{ Auth::user()->name }}" disabled>
                <input type="hidden" name="name" value="{{ Auth::user()->name }}">
            </div>
        @endif

        <div class="col-sm-6 col-md-3 col-xs-12 my-2">
            <input type="text" id="booktable" class="form-control form-control-lg custom-form-control" 
                   name="phone" placeholder="Téléphone" required>
        </div>

        <div class="col-sm-6 col-md-3 col-xs-12 my-2">
            <input type="number" id="booktable" class="form-control form-control-lg custom-form-control" 
                   name="guest" placeholder="NOMBRE D'INVITES" max="20" min="1" required>
        </div>

        <div class="col-sm-6 col-md-3 col-xs-12 my-2">
            <input type="time" id="booktable" class="form-control form-control-lg custom-form-control" 
                   name="time" placeholder="Heure" required>
        </div>

        <div class="col-sm-6 col-md-3 col-xs-12 my-2">
            <input type="date" id="booktable" class="form-control form-control-lg custom-form-control" 
                   name="date" placeholder="Date" required>
        </div>

        <div class="col-sm-6 col-md-3 col-xs-12 my-2">
            <select name="table_id" class="form-control form-control-lg custom-form-control" required>
                <option value="">Choisir une table</option>

                @foreach($tables as $table)
                    <option value="{{ $table->id }}">
                        Table {{ $table->nom_table }} ({{ $table->capacite }} pers.)
                    </option>
                @endforeach
            </select>
        </div>

    </div>

    <input type="submit" class="btn btn-lg btn-primary" id="rounded-btn" value="Reserver une table">
</form>

        
        </div>


    </div>
