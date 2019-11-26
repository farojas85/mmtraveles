var app = new Vue({
    el:'#wrapper',
    data:{
       roles:[],
       locales:[],
       total_roles:'',
       users:[],
       user:{
           id:'',
           name:'',
           lastname:'',
           username:'',
           email:'',
           password:'',
           local_id:'',
           role_id:'',
           is_active:1
       },
       total_users:0,
       errores:[],
       mostrar_password:false,
       offset:4,
    },
    computed:{
        isActived() {
            return this.users.current_page;
        },
        pagesNumber() {
            if (!this.users.to) {
                return [];
            }
            var from = this.users.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.users.last_page) {
                to = this.users.last_page;
            }
            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        }
    },
    methods: {
        listarRoles() {
            axios.get('/roles/filtro').then(({ data }) => (
                this.roles = data
            ))
        },
        listarLocales() {
            axios.get('/locales/filtro').then(({ data }) => (
                this.locales = data
            ))
        },
        listar() {
            axios.get('/user/lista').then(({ data }) => (
                this.users = data,
                this.total_users = this.users.total
             ))
        },
        getResults(page=1) {
            axios.get('/user/lista?page=' + page)
            .then(response => {
                this.users = response.data
                this.total_users = this.users.total
            });

        },
        changePage(page) {
            this.users.current_page = page
            this.getResults(page)
        },
        limpiar(){
            this.errores=[]
            this.user.id=''
            this.user.name = ''
            this.user.lastname=''
            this.user.username=''
            this.user.email=''
            this.user.local_id=''
            this.user.role_id=''
            this.user.password=''
            this.user.is_active =1
        },
        nuevo()
        {
            this.limpiar()
            this.listarLocales()
            this.listarRoles()
            $('#user-create').modal('show')
        },
        guardar() {
            axios.post('user/store',this.user)
                .then((response) => {
                    Swal.fire({
                        type : 'success',
                        title : 'USUARIOS',
                        text : response.data.mensaje,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    }).then(respuesta => {
                        if(respuesta.value) {
                            $('#USER-create').modal('hide')
                            this.listar()
                            this.getResults()
                        }
                    })
                })
                .catch((errors) => {
                    if(response = errors.response) {
                        this.errores = response.data.errors,
                        console.clear()
                    }
                })
        },
        cargarDatos(id){
            axios.get('user/show',{params: {id:id }})
                .then((response) => {
                    console.log(response.data)
                    this.user.id= response.data.id
                    this.user.name= response.data.name
                    this.user.lastname= response.data.lastname
                    this.user.username = response.data.username
                    this.user.password = response.data.password2
                    this.user.email= response.data.email
                    this.user.local_id= response.data.local_id
                    this.user.role_id = response.data.roles[0]['id']
                    this.user.is_active = response.data.is_active
                })
        },
        mostrar(id){
            this.limpiar()
            this.listarRoles()
            this.listarLocales()
            this.cargarDatos(id)
            $('#user-show').modal('show')
        },
        editar(id) {
            this.limpiar()
            this.listarRoles()
            this.listarLocales()
            this.cargarDatos(id)
            $('#user-edit').modal('show')
        },
        actualizar() {
            axios.put('user/update',this.user)
                .then((response) => {
                    Swal.fire({
                        type : 'success',
                        title : 'USUARIO',
                        text : response.data.mensaje,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    }).then(respuesta => {
                        if(respuesta.value) {
                            $('#user-edit').modal('hide')
                            this.listar()
                            this.getResults()
                        }
                    })
                })
                .catch((errors) => {
                    if(response = errors.response) {
                        this.errores = response.data.errors,
                        console.clear()
                    }
                })
        },
        eliminar(id){
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
                    axios.post('/user/destroy',{id:id})
                    .then((response) => (
                        swal.fire({
                            type : 'success',
                            title : 'USUARIOS',
                            text : response.data.mensaje,
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor:"#1abc9c",
                        }).then(respuesta => {
                            if(respuesta.value) {
                                this.listar(),
                                this.getResults()
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
        },
        mostrarPasswords(){
            this.mostrar_password = !this.mostrar_password;
        }
    },
    created() {
        this.listar()
        this.getResults()
    }
})
