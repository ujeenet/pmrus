<script>
    export default {
        data: function () {
            return {
                resources: [],
                errors: {}
            }
        },
        methods: {
            getResourceList: function () {
                axios.get('/resource/listall').then(function(response){
                    this.resources = response.data;
                }.bind(this)).catch(function (errors) {
                    console.log(errors);
                });
            },
            deleteResource: function (array, id){
                console.log(array);
                console.log(id);
                this.resources.splice(array,1);
                axios.delete('/resource/delete/'+id);
            }
        },
        mounted: function () {
            this.getResourceList();
        },
        created: function(){
            Event.$on('addresourceresponse', function(response){
                this.resources.unshift(
                    {
                        'name': response.name,
                        'middlename': response.middlename,
                        'lastname': response.lastname,
                        'id': response.id,
                        'phone': response.phone,
                        'email': response.email,
                        'owner_id': response.owner_id,
                        'title': response.title,
                        'birthdate': response.birthdate,
                        'created_at': response.created_at,
                        'updated_at': response.updated_at
                    });
            }.bind(this));
        }
    }
</script>