<div class="row">
    <div class="col-sm-3">
        <div class="card"  style="border:1px solid #4fc6e1 !important">
            <div class="card-header bg-info py-2 text-white">
                <h5 class="card-title mb-0 text-white">ROLES</h5>
            </div>
            <div id="cardCollpase6" class="collapse show">
                <div class="card-body">
                    <div class="nav flex-column nav-pills nav-pills-tab" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link mb-2" v-for="rol in role_filtro" :key="rol.id"
                            :class=""
                            href="#" data-toggle="pill" @click="listarPermissionRoles(rol.id)">
                            @{{rol.name}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-9">
        @include('configuraciones.permission_role.permissions')
    </div>
</div>
