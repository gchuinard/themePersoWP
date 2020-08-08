<!-- L'action permet que la recher se fasse sur tout le site peu importe la page actuelle -->
<form class="form-inline my-2 my-lg-0" action="<?= esc_url(home_url('/')) ?>">
    <input class="form-control mr-sm-2" type="search" name="s" placeholder="Rechercher" aria-label="Search" value="<?= get_search_query(); ?>">
    <button class="btn btn-outline my-2 my-sm-0" type="submit">Rechercher</button>
</form>