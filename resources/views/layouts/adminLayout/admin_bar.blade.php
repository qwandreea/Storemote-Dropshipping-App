<!--sidebar-menu-->
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i>Panou administrator</a>
    <ul>
        <li class="active"><a href="{{ url('/admin/tablou') }}"><i class="icon icon-home"></i>
                <span>Panou administrator</span></a></li>
        <li><a class="active" href="{{ url('/') }}"><i class="icon icon-home"></i> <span>Mergi la magazin</span></a>
        </li>
        <li class="submenu"><a href="#"><i class="icon icon-th-list"></i><span>Categorii</span></a>
            <ul>
                <li><a href="{{ url('/admin/adauga-categorie') }}">Adauga categorie</a></li>
                <li><a href="{{ url('/admin/vizualizeaza-categorii') }}">Lista de categorii</a></li>
            </ul>
        </li>
        <li class="submenu"><a href="#"><i class="icon icon-th-list"></i><span>Produse</span></a>
            <ul>
                <li><a href="{{ url('/admin/adauga-produs') }}">Adauga produs</a></li>
                <li><a href="{{ url('/admin/vizualizeaza-produse') }}">Lista de produse si specificatii</a></li>
            </ul>
        </li>
        <li class="submenu"><a href="#"><i class="icon icon-th-list"></i><span>Furnizori</span></a>
            <ul>
                <li><a href="{{ url('/admin/adauga-furnizor') }}">Adauga furnizor</a></li>
                <li><a href="{{ url('/admin/vizualizeaza-furnizori') }}">Lista de furnizori</a></li>
            </ul>
        </li>
        <li><a href="{{ url('/admin/informatii-contact') }}"><i class="icon icon-th-list"></i><span>Informatii de contact</span></a>
        </li>
        <li><a href="{{ url('/admin/promotii') }}"><i class="icon icon-th-list"></i><span>Banner promotii</span></a>
        </li>
        <li><a href="{{ url('/admin/solicitari-inchiriere') }}"><i class="icon icon-th-list"></i><span>Solicitari de inchiriere</span></a>
        </li>
        <li><a href="{{ url('/admin/vizualizare-taxe') }}"><i class="icon icon-th-list"></i><span>Modifica taxa pe regiuni</span></a>
        </li>
        <li><a href="{{ url('/admin/forum-clienti') }}"><i class="icon icon-th-list"></i><span>Forum clienti</span></a>
        </li>

        <li class="submenu"><a href="#"><i class="icon icon-th-list"></i><span>Comenzi</span></a>
            <ul>
                <li><a href="{{ url('/admin/comenzi/lista-comenzi') }}">Lista de comenzi</a></li>
            </ul>
        </li>
    </ul>
</div>
<!--sidebar-menu-->
