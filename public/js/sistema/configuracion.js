var app = new Vue({
    el:'#wrapper',
    data:{
        roles:[],
        role:{
            id:'',
            name:'',
            guard_name:''
        },
        total_roles:'',
        role_filtro:[],
        permissions:[],
        total_permissions:0,
        permission:{
            id:'',
            name:'',
            guard_name:''
        },
        desde_permission:1,
        permission_filtro:[],
        permission_role:{
            role_id:'',
            role_name:'',
            permission_name:[]
        },
       errores:[],
       offset:4
    },
    computed:{
        isActivedRole() {
            return this.roles.current_page;
        },
        pagesNumberRole() {
            if (!this.roles.to) {
                return [];
            }
            var from = this.roles.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.roles.last_page) {
                to = this.roles.last_page;
            }
            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        },
        isActivedPermission() {
            return this.permissions.current_page;
        },
        pagesNumberPermission() {
            if (!this.permissions.to) {
                return [];
            }
            var from = this.permissions.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.permissions.last_page) {
                to = this.permissions.last_page;
            }
            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        },
    },
    methods:{
        listarRole() {
            axios.get('/roles/lista').then(({ data }) => (
                this.roles = data,
                this.total_roles = this.roles.total
             ))
        },
        getResultsRole(page=1) {
            axios.get('/roles/lista?page=' + page)
            .then(response => {
                this.roles = response.data
                this.total_roles = this.roles.total
            });
        },
        changePageRole(page) {
            this.aerolineas.current_page = page
            this.getResults(page)
        },
        limpiar(tabla){
            this.errores=[]
            switch(tabla){
                case 'role':
                    this.role.id=''
                    this.role.name=''
                    this.role.guard_name=''
                    break
                case 'estilo-aprendizaje':
                    this.estilo_aprendizaje.id=''
                    this.estilo_aprendizaje.nombre=''
                    this.estilo_aprendizaje.descripcion=''
                    this.estilo_aprendizaje.estado=''
                    break
                case 'area':
                    this.area.id=''
                    this.area.siglas=''
                    this.area.nombre=''
                    this.area.estado=''
                    break
                case 'personalidad':
                    this.personalidad.id=''
                    this.personalidad.codigo=''
                    this.personalidad.nombre=''
                    this.personalidad.estado=''
                case 'ocupacion':
                    this.ocupacion.id=''
                    this.ocupacion.nombre=''
                    this.ocupacion.area_id=''
                    this.ocupacion.personalidad_id=''
                    this.ocupacion.estado=''
            }
        },
        nuevoRole()
        {
            this.limpiar('role')
            $('#role-create').modal('show')
        },
        listarPermission() {
            axios.get('/permissions/lista').then(({ data }) => (
                this.permissions = data,
                this.total_permissions = this.permissions.total,
                this.desde_permission = this.permission.from
             ))
        },
        getResultsPermission(page=1) {
            axios.get('/permissions/lista?page=' + page)
            .then(response => {
                this.permissions = response.data,
                this.desde_permission = this.permissions.from
                this.total_permissions = this.permissions.total
            });
        },
        changePagePermission(page) {
            this.permissions.current_page = page
            this.desde_permission = this.permissions.from
            this.getResultsPermission(page)
        },
        buscarPermiso(e) {
            axios.get('permissions/buscar',{params:{texto:e.target.value}})
            .then((response) => {
                this.permissions = response.data;
                this.total_permissions = this.permissions.total
                this.desde_permission = this.permissions.from
            })
        },
        nuevoPermiso() {
            this.permission.id='',
            this.permission.name='',
            this.permission.guard_name=''
            this.errores=[]
            $('#permission-create').modal('show')
        },
        guardarPermiso() {
            axios.post('/permissions/guardar',this.permission)
            .then((response) => (
                swal.fire({
                    type : 'success',
                    title : 'PERMISOS',
                    text : response.data.mensaje,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor:"#1abc9c",
                }).then(respuesta => {
                    if(respuesta.value) {
                        $('#permission-create').modal('hide'),
                        this.listarPermission()
                        this.getResultsPermission()
                    }
                })
            ))
            .catch((errors) => {
                if(response = errors.response) {
                    this.errores = response.data.errors,
                    console.clear()
                }
            })
        },
        mostrarPermiso(id) {
            axios.get('permissions/mostrar',{params: {id:id}})
            .then((response) => {
                this.permission =response.data
                $('#permission-show').modal('show')
            })
        },
        editarPermiso(id) {
            axios.get('permissions/mostrar',{params: {id:id}})
            .then((response) => {
                this.permission =response.data
                $('#permission-edit').modal('show')
            })
        },
        actualizarPermiso() {
            axios.post('/permissions/actualizar',this.permission)
            .then((response) => (
                swal.fire({
                    type : 'success',
                    title : 'PERMISOS',
                    text : response.data.mensaje,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor:"#1abc9c",
                }).then(respuesta => {
                    if(respuesta.value) {
                        $('#permission-edit').modal('hide'),
                        this.listarPermission()
                        this.getResultsPermission()
                    }
                })
            ))
            .catch((errors) => {
                if(response = errors.response) {
                    this.errores = response.data.errors,
                    console.clear()
                }
            })
        },
        eliminarPermiso(id){
            swal.fire({
                title:"¿Está Seguro de Eliminar?",
                text:'No podrás revertirlo',
                type:"question",
                showCancelButton: true,
                confirmButtonText:"Si",
                confirmButtonColor:"#38c172",
                cancelButtonText:"No",
                cancelButtonColor:"#e3342f"
            }).then( response => {
                if(response.value){
                    axios.post('/permissions/eliminar',{id:id})
                    .then((response) => (
                        swal.fire({
                            type : 'success',
                            title : 'PERMISOS',
                            text : response.data.mensaje,
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor:"#1abc9c",
                        }).then(respuesta => {
                            if(respuesta.value) {
                                this.listarPermission()
                                this.getResultsPermission()
                            }
                        })
                    ))
                    .catch((errors) => {
                        if(response = errors.response) {
                            this.errores = response.data.errors
                        }
                    })
                }
            }).catch(error => {
                this.$Progress.fail()
                swal.showValidationError(
                    `Ocurrió un Error: ${error.response.status}`
                )
            })
                //
        },
        filtroRoles() {
            axios.get('/roles/filtro').then(({ data }) => (
                this.role_filtro = data
            ))
        },
        filtroPermissions() {
            axios.get('/permissions/filtro').then(({ data }) => (
                this.permission_filtro = data
            ))
        },
        listarPermissionRoles(id) {
            this.permission_role.role_id = id
            axios.get('/permission-role/listarPermissionRoles',{params: {id: id}})
            .then((response ) => {
                let permisos =response.data
                this.filtroPermissions()
                this.permission_role.permission_name = []
                this.permission_role.role_name = permisos[0].name
                if(permisos.length >0 )
                {
                    if(permisos[0].permissions.length > 0)
                    {
                        for(let i=0; i<permisos[0].permissions.length; i++)
                        {
                            this.permission_role.permission_name.push(permisos[0].permissions[i].name)
                        }
                    }
                }
            })
        },
        guardarPermissionRole()
        {
            axios.post('/permission-role/guardar',this.permission_role)
                .then((response) => (
                    swal.fire({
                        type : 'success',
                        title : 'PERMISOS',
                        text : response.data.mensaje,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    }).then(respuesta => {
                        if(respuesta.value) {
                            this.listarPermissionRoles(this.permission_role.role_id)
                        }
                    })
                ))
                .catch((errors) => {
                    if(response = errors.response) {
                        this.errores = response.data.errors,
                        console.clear()
                    }
                })
        }
    },
    created() {
        this.listarRole()
        this.getResultsRole()
        this.listarPermission()
        this.getResultsPermission()
        this.filtroRoles()
    }
})
