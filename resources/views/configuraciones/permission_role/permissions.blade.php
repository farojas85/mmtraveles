<div class="card" style="border:1px solid #f1556c !important">
    <div class="card-header bg-danger py-2 text-white">
        <h5 class="card-title mb-0 text-white" v-if="permission_role.role_name">
            Permisos Para:... @{{permission_role.role_name}}
        </h5>
    </div>
    <div id="cardCollpase4" class="collapse show">
        <div class="card-body">
            <div class="tab-content pt-0" id="tab-contenido">
                <div v-for="permiso in permission_filtro" :key="permiso.id">
                    <label>
                        <input type="checkbox" v-model="permission_role.permission_name" :value="permiso.name">
                        @{{ permiso.name }}
                    </label>
                </div>
                <div class="row container-fluid text-center">
                    <button type="button" class="btn btn-success" @click="guardarPermissionRole">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
