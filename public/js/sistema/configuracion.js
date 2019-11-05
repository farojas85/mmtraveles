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
       errores:[],
       offset:4,
       showdeletes_role:false
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
    },
    methods:{
        listarRole() {
            axios.get('/roles/lista').then(({ data }) => (
                this.roles = data,
                this.total_roles = this.roles.total
             ))
        },
        getResultsRole(page=1) {
            if(this.showdeletes_role == false) {
                axios.get('/roles/lista?page=' + page)
                .then(response => {
                    this.roles = response.data
                    this.total_roles = this.roles.total
                });
            }
            else {
                axios.get('/roles/mostrarEliminados?page=' + page)
                .then(response => {
                    this.roles = response.data
                    this.total_roles = this.roles.total
                });
            }
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
    },
    created() {
        this.listarRole()
        this.getResultsRole()
    }
})
