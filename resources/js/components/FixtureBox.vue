<template>
  <div class="row fixtures-box">
    <div class="col-md-8">
      <table class="table table-hover">
        <thead>
          <tr>
            <td class="make-center" colspan="3">
              <h3>Future Fixtures</h3>
            </td>
          </tr>
        </thead>
        <tbody id="table-body">
          <template v-for="week in weeks">
            <tr>
              <td colspan="3" class="fixtures-box_header">
                {{ week.title }} Week Matches
              </td>
            </tr>
            <template v-for="match in matches">
              <!-- <template v-for="(week, index) of weeks"> 
                
            </template> -->
              <template v-for="matchh in match">
                <template v-if="matchh.week_id == week.id">
                  <tr>
                    <td class="make-center">
                      <!-- <img width="30" height="30" src="" />
                      <img width="60" height="60" src="" /> -->
                      {{ matchh["home_team"] }}
                    </td>
                    <td class="make-center">
                      {{ matchh["home_team_goal"] }}
                      {{ matchh["away_team_goal"] }}
                    </td>
                    <td class="make-center">
                      <!-- <img width="30" height="30" src="" />
                      <img width="60" height="60" src="" /> -->
                      {{ matchh["away_team"] }}
                    </td>
                  </tr>
                </template>
              </template>
            </template>
            <tr v-if="week.status == 0">
              <td colspan="5" class="make-center">
                <button
                  :data-week="week.id"
                  class="btn btn-primary ="
                  @click="playWeek(week.id)"
                >
                  Simulate {{ week.title }} Week
                </button>
              </td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>
    <div class="col-md-4">
      <div class="row">
        <h3 class="make-center make-full-width">Simulation Managements</h3>
        <div class="make-center make-full-width">
          <button class="btn btn-success" @click="playAllWeeks()">
            Simulate All Weeks
          </button>
        </div>
        <div class="make-full-width make-center">
          <button class="btn btn-danger" @click="reset()">Reset All</button>
        </div>
      </div>
      <div class="row prediction-wrapper">
        <h3 class="prediction-box_title">Champion Prediction</h3>
        <table class="table table-dark make-full-width">
          <thead>
            <tr>
              <th scope="col">Team</th>
              <th scope="col">Percentage</th>
            </tr>
          </thead>
          <tbody>
            <template v-for="(value, index) in predictions">
              <tr>
                <th scope="row">{{ index }}</th>
                <td>{{ value }} %</td>
              </tr>
            </template>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  data() {
    return {
      weeks: [],
      matches: [],
      predictions: [],
    };
  },

  created() {
    this.getStarted();
  },
  methods: {
    getStarted() {
      fetch("api/getStarting")
        .then((res) => res.json())
        .then((res) => {
          this.weeks = res.weeks;
          this.matches = res.matches;
          this.predictions = res.predictions;
        });
      // console.log(predictions);
    },

    reset() {
      if (confirm("Are You Sure?")) {
        fetch("api/reset-all")
          .then((res) => res.json())
          .then((res) => {
            console.log(res);
            if (res.status == "ok") {
              this.refreshFixture();
            }
          });
      }
    },

    refreshFixture() {
      fetch("api/fixtures")
        .then((res) => res.json())
        .then((res) => {
          console.log(res);
          this.weeks = res.weeks;
          this.matches = res.items;
          this.$root.$refs.ScoreTable.fetchScore();
        });
    },
    playWeek(week_id) {
      fetch(`api/play-week/${week_id}`)
        .then((res) => res.json())
        .then((res) => {
          //   console.log(res)
          this.refreshFixture();
          this.getPredictions();
        });
    },
    playAllWeeks() {
      fetch("api/play-all-weeks")
        .then((res) => res.json())
        .then((res) => {
          //   console.log(res)
          this.refreshFixture();
          this.getPredictions();
        });
    },
    getPredictions() {
      fetch("api/prediction")
        .then((res) => res.json())
        .then((res) => {
          //   console.log(res)
          this.predictions = res.predictions;
        });
    },
  },
};
</script>