<div class="appBottomMenu">
    <a href="/dashboard" class="item {{ $title == 'Dashboard' ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="home-outline"></ion-icon>
            <strong>Home</strong>
        </div>
    </a>
    <a href="/histori" class="item {{ $title == 'Histori Presensi' ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="document-outline" role="img" class="md hydrated" aria-label="calendar outline">
            </ion-icon>
            <strong>Histori</strong>
        </div>
    </a>
    <a href="/presensi" class="item">
        <div class="col">
            <div class="action-button large">
                <ion-icon name="camera" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
            </div>
        </div>
    </a>
    <a href="/izin" class="item {{ $title == 'Izin' ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="calendar-outline" role="img" class="md hydrated" aria-label="document text outline">
            </ion-icon>
            <strong>Izin</strong>
        </div>
    </a>
    <a href="/profil" class="item {{ $title == 'Profil' ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="people-outline" role="img" class="md hydrated" aria-label="people outline"></ion-icon>
            <strong>Profile</strong>
        </div>
    </a>
</div>
