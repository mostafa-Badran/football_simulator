<template>
     <div class="row score-box">
            <div class="col-md-12">
                <h2 class="score-box_title">Score</h2>
                <div class="table-responsive">
                    <table id="score-table" class="table table-bordred table-striped">
                        <thead>
                        <th>Teams</th>
                        <th>P</th>
                        <th>W</th>
                        <th>D</th>
                        <th>L</th>
                        <th>GD</th>
                        <th>PTS</th>
                        </thead>
                        <tbody>
                            <!-- loop to view score -->
                            <tr v-for="team in scores" v-bind:key="team.id">
                                <td>
                                   
                                    {{team.name}}
                                </td>
                                 <td>{{team.played}}</td>
                                <td>{{team.won}}</td>
                                <td>{{team.draw}}</td>
                                <td>{{team.lose}}</td>
                                <td>{{team.goal_drawn}}</td>
                                <td>{{team.points}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        
</template>

<script>
export default {
    data() {
        return {
            scores:[],
         
        }
    },

created() {
    this.$root.$refs.ScoreTable = this;
    this.fetchScore();
},
    methods: {
        fetchScore(){
            console.log("ccc");
            fetch('api/scores')
            .then(res=>res.json())
            .then(res =>{
                this.scores = res;
            })
           
        }
    },
}
</script>