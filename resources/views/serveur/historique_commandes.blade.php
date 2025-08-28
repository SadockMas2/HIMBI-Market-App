@extends('serveur.index')


<style>


</style>
@section('content')
<div class="page-content">
    <h2>Historique de mes commandes</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Table</th>
                <th>Plat</th>
                <th>Quantité</th>
                <th>Statut</th>
                <th>Paiement</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commandes as $commande)
                <tr>
                    <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $commande->table->nom_table }}</td>
                    <td>{{ $commande->food->title }}</td>
                    <td>{{ $commande->quantite }}</td>
                    <td>{{ ucfirst($commande->statut) }}</td>
                    <td>{{ ucfirst($commande->payment_status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script src="https://js.pusher.com/8.2/pusher.min.js"></script>
<script src="{{ asset('js/echo.js') }}"></script>

<script>
    Pusher.logToConsole = false;

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: "{{ env('PUSHER_APP_KEY') }}",
        cluster: "{{ env('PUSHER_APP_CLUSTER', 'mt1') }}",
        forceTLS: true
    });

    Echo.channel('commandes')
        .listen('.commande.confirmee', (e) => {
            console.log("Nouvelle commande :", e);

            // Jouer le son
            const audio = document.getElementById('notifSound');
            if(audio){
                audio.play().catch(err => console.log("Erreur audio:", err));
            }

            // Ajouter un spam dans la sidebar
            const sidebar = document.getElementById('sidebarNotifications');
            if(sidebar){
                e.commande.forEach(item => {
                    const div = document.createElement('div');
                    div.className = 'notification';
                    div.innerHTML = `Nouvelle commande de <strong>${item.client_name}</strong> : ${item.title} x ${item.quantity}`;
                    sidebar.prepend(div);
                });
            }
        });
</script>
@endpush
