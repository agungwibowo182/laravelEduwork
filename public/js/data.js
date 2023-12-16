var controller = new Vue({
    el:'#controller',
    data: {
        datas:[],
        data:{},
        actionUrl,
        apiUrl,
        editStatus:false,
    },
    mounted:function() {
        this.datatable();
    },
    methods: {
        datatable(){
            const _this = this;
            _this.table = $('#datatable').DataTable({
                ajax: {
                    url: _this.apiUrl,
                    type:'GET',
                },
                columns
            }).on('xhr', function(){
                _this.datas = _this.table.ajax.json().data;
            });
        },
        addData() {
            this.data = {};
            this.editStatus = false;
            $('#modal-default').modal();
        },
        editData(event, row) {
            const _this = this;
            _this.data = { ..._this.datas[row] }; // Make a copy to avoid modifying the original data
            _this.editStatus = true;
            $('#modal-default').modal();
        },
        deleteData(event, id) {
            const _this = this;
            if (confirm("Are you sure?")) {
                $(_this.$refs.modal).modal('hide'); // Use _this consistently
                axios.post(this.actionUrl + '/' + id, { _method: 'DELETE' }).then(response => {
                    alert('Data has been removed');
                    _this.table.ajax.reload();
                });
            }
        },        
        submitForm(event) {
            event.preventDefault();
            const _this = this;
        
            // Ensure data.id is set before using it in the actionUrl
            const actionUrl = !this.editStatus ? this.actionUrl : (this.data.id ? this.actionUrl + '/' + this.data.id : this.actionUrl);
        
            // Add _method field for Laravel to recognize it as a PUT request
            const formData = new FormData($(event.target)[0]);
            if (this.editStatus) {
                formData.append('_method', 'PUT');
            }
        
            axios.post(actionUrl, formData).then(response => {
                $('#modal-default').modal('hide');
                _this.table.ajax.reload();
            });
        }
        
        
    }
});