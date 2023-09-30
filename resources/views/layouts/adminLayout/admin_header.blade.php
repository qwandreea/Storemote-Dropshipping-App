<!--Header-part-->
<div id="header">
    <h1><a href="dashboard.html">Pagina administrator</a></h1>
</div>
<!--close-Header-part-->

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse" style="padding-left: 20px;">
    <ul class="nav">
        <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">Cont administrator</span><b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="{{url('/admin/setari')}}"><i class="icon-user"></i>Profil</a></li>
                <li class="divider"></li>
                <li><a href="{{url('/logout')}}"><i class="icon-key"></i>Iesire</a></li>
            </ul>
        </li>
        <li class=""><a title="" href="{{url('/admin/setari')}}"><i class="icon icon-cog"></i> <span class="text">Setari cont</span></a></li>
        <li class=""><a title="" href="{{url('/logout')}}" ><i class="icon icon-share-alt"></i> <span class="text">Iesire</span></a></li>
    </ul>
</div>
<!--close-top-Header-menu-->
<!--start-top-serch-->
<div id="search">
    <input type="text" placeholder="Cauta..."/>
    <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-serch-->
