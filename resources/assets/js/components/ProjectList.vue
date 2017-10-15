<script>
    export default {
        props: ['listbystatus']
        ,
        data: function () {
            return {
                project: {
                    title: "",
                    description: "",
                    type: "",
                    status: "",
                    starts_at: "",


                },
                resources:[],
                status:"",
                forms: {
                },
                formsOnhold: {
                },
                formsDone: {
                },
                formsDiscard: {
                }
            }
        },
        methods:{
            getProjects: function (link){
                axios.get(link).then(function(response){
                    console.log (response.data);
                    this.forms = response.data.in_process;
                    this.formsOnhold = response.data.on_hold;
                    this.formsDone = response.data.done;
                    this.formsDiscard = response.data.discard;

                }.bind(this)).catch(function(errors){
                    console.log(errors);
                });
            },
            prevPage: function () {
                if (this.forms.prev_page_url !=null) {
                    this.getProjects(this.forms.prev_page_url);
                }
                },
            nextPage: function () {
                if (this.forms.next_page_url !=null) {
                    this.getProjects(this.forms.next_page_url);
                }
                },
            getPage: function (num){
                this.getProjects("http://laravel.my/project/listall/"+this.listbystatus+"?page="+num);
                },
            getResourceList: function () {
                axios.get('/resource/listall').then(function(response){
                    this.resources = response.data;
                }.bind(this)).catch(function (errors) {
                    console.log(errors);
                });
            },
            updateProject: function(pid, pstatus, pdate){
                axios.post('/project/update/'+ pid, {status: pstatus, starts_at: pdate}).then(function (response) {
                    this.getProjects("/project/listall/"+this.listbystatus);
                }.bind(this)).catch(function (errors) {
                    console.log(errors);
                });
            },
            discardProject: function (id, index){
                axios.get('/project/discard/'+ id).then(function(response)
                {
                    this.forms.data.splice(index, 1);
                    console.log(response);
                }.bind(this));

            },
            sendForms: function () {
                axios.post('/checkpoint/update', {forms:this.forms}).then(function()
                {
                    this.estimateDates();

                }.bind(this)).catch(function(errors){
                    console.log(errors);
                });

            },
            addProject: function () {
                axios.post("/project/create", {"project": this.project}).then(function(response)
                {
                    this.forms.data.push({
                        'id': response.data.id,
                        'title': response.data.title,
                        'estimated_duration': response.data.estimated_duration,
                        'status': response.data.status,
                        'type': response.data.type,
                        'starts_at': response.data.starts_at,
                        'created_at': response.data.created_at,
                        'updated_at': response.data.updated_at,
                        'resource_id': response.data.resource_id,
                    });
                }.bind(this)).catch(function (errors) {
                   console.log(errors);
                });
            },
            estimateDates: function () {
                axios.get('/checkpoint/estimate/' + this.pid).then(function (response) {

                    this.forms = response.data;
                    this.forms.sort(function (a, b) {
                        return a.priority - b.priority;
                    });
                }.bind(this)).catch(function (errors) {
                    console.log(errors);
                });
            },
            convertTime:function (timestamp){

                var d = new Date(timestamp*1000);

                var curr_date = d.getDate();

                var curr_month = d.getMonth() + 1;

                var curr_year = d.getFullYear();

                return (curr_year + "-" + curr_month + "-" + curr_date);

            }
        },
        created: function (){
            this.getProjects("/project/listall/"+this.listbystatus);
            this.getResourceList();
        }
    }
</script>