<nav class="custom-wrapper" id="menu">
    <div class="pure-menu"></div>
    <ul class="container-flex list-unstyled">
        <li><a href="{{ route('pages.inicio') }}" class="text-uppercase {{ setActiveRoute('pages.inicio') }}">Inicio</a></li>
        <li><a href="{{ route('pages.nosotros') }}" class="text-uppercase {{ setActiveRoute('pages.nosotros') }}">Nosotros</a></li>
        <li><a href="{{ route('pages.archivo') }}" class="text-uppercase {{ setActiveRoute('pages.archivo') }}">Archivo</a></li>
        <li><a href="{{ route('pages.contacto') }}" class="text-uppercase {{ setActiveRoute('pages.contacto') }}">Contacto</a></li>
    </ul>
</nav>
