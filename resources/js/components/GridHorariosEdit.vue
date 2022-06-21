<template>
    <div>
        <div class="alert alert-danger" v-if="showAlert">
            <button type="button" class="close" @click="showAlert = !showAlert">×</button>
            Para añadir un nuevo campo primero llene los datos del anterior.
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" class="text-primary">Lunes</th>
                        <th scope="col" class="text-secondary">Martes</th>
                        <th scope="col" class="text-success">Miércoles</th>
                        <th scope="col" class="text-danger">Jueves</th>
                        <th scope="col" class="text-warning">Viernes</th>
                        <th scope="col" class="text-info">Sábado</th>
                        <th scope="col" class="text-dark">Domingo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td v-for="(row, i) in listaHorarios" :key="i">
                            <div :class="`card bg-gradient-${row.color}`" v-for="(item, j) in row.horarios" :key="j">
                                <div class="modal-header">
                                    <h5 class="modal-title">Horario #{{ j+1 }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="removeItem(i, j)">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="card-body p-2">
                                    <div class="form-group mb-1">
                                        <small>Título</small>
                                        <input type="text" class="form-control form-control-sm" v-model="item.title" :name="`horarios[${row.day}][${j}][titulo]`" placeholder="Título" required>
                                    </div>
                                    <div class="form-group mb-1">
                                        <small>Hora de inicio</small>
                                        <input type="time" :min="item.min" class="form-control form-control-sm" v-model="item.start" :name="`horarios[${row.day}][${j}][hora_inicio]`" required>
                                    </div>
                                    <div class="form-group">
                                        <small>Hora fin</small>
                                        <input type="time" :min="item.start" class="form-control form-control-sm" v-model="item.end" :name="`horarios[${row.day}][${j}][hora_fin]`" required>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="button" class="btn btn-secondary btn-sm" @click="addItem(i)">Añadir</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            showAlert: false,
            listaHorarios: [
                {
                    day: 'Mon',
                    color: 'primary',
                    horarios: []
                },
                {
                    day: 'Tue',
                    color: 'secondary',
                    horarios: []
                },
                {
                    day: 'Wed',
                    color: 'success',
                    horarios: []
                },
                {
                    day: 'Thu',
                    color: 'danger',
                    horarios: []
                },
                {
                    day: 'Fri',
                    color: 'warning',
                    horarios: []
                },
                {
                    day: 'Sat',
                    color: 'info',
                    horarios: []
                },
                {
                    day: 'Sun',
                    color: 'dark',
                    horarios: []
                },
            ]
        }
    },
    props: ['horarios'],
    mounted() {
        var tmpHorarios = JSON.parse(this.horarios);
        // console.log(tmpHorarios);
        tmpHorarios.forEach(element => {
            switch (element.dia) {
                case 'Mon':
                    this.listaHorarios[0].horarios.push({
                        title: element.titulo,
                        start: element.hora_inicio,
                        end: element.hora_fin
                    })
                    break;
                case 'Tue':
                    this.listaHorarios[1].horarios.push({
                        title: element.titulo,
                        start: element.hora_inicio,
                        end: element.hora_fin
                    })
                    break;
                case 'Wed':
                    this.listaHorarios[2].horarios.push({
                        title: element.titulo,
                        start: element.hora_inicio,
                        end: element.hora_fin
                    })
                    break;
                case 'Thu':
                    this.listaHorarios[3].horarios.push({
                        title: element.titulo,
                        start: element.hora_inicio,
                        end: element.hora_fin
                    })
                    break;
                case 'Fri':
                    this.listaHorarios[4].horarios.push({
                        title: element.titulo,
                        start: element.hora_inicio,
                        end: element.hora_fin
                    })
                    break;
                case 'Sat':
                    this.listaHorarios[5].horarios.push({
                        title: element.titulo,
                        start: element.hora_inicio,
                        end: element.hora_fin
                    })
                    break;
                case 'Sun':
                    this.listaHorarios[6].horarios.push({
                        title: element.titulo,
                        start: element.hora_inicio,
                        end: element.hora_fin
                    })
                    break;
            
                default:
                    break;
            }
        });
    },
    methods: {
        addItem(i) {
            var tmp = this.listaHorarios[i].horarios;
            var min = '';
            if (tmp.length > 0) {
                if (tmp[tmp.length-1].title=='' || tmp[tmp.length-1].start=='' || tmp[tmp.length-1].end=='') {
                    this.showAlert = true;
                    return;
                }
                min = tmp[tmp.length-1].end;
            }
            this.showAlert = false;
            this.listaHorarios[i].horarios.push({title: '', start: '', end: '', min: min});
        },
        removeItem(i, j) {
            this.listaHorarios[i].horarios.splice(j, 1)
        }
    },
}
</script>
<style lang="scss">
.card {
    .modal-header {
        padding: 5px 10px;
    }
    .modal-title {
        font-size: 14px;
        line-height: 20px;
    }
}
</style>