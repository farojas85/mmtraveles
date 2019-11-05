var app = new Vue({
    el:'#wrapper',
    data:{
       roles:[],
       total_roles:'',
       users:[],
       user:{},
       total_users:0,
       errores:[],
       offset:4,
       showdeletes_user:false
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
        },
    },
})
