<template>
    <div>
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img style="height: 500px" class="d-block w-100" src="image/school-1.jpg"
                         alt="First slide">
                </div>
                <div class="carousel-item">
                    <img style="height: 500px" class="d-block w-100" src="image/school-2.jpg"
                         alt="Second slide">
                </div>
                <div class="carousel-item">
                    <img style="height: 500px" class="d-block w-100" src="image/school-3.jpg"
                         alt="Third slide">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <section class="text-center mt-5">
            <div class="row mb-4 wow fadeIn">
                <div class="col-lg-4 col-md-12 mb-4">
                    <div class="card">
                        <div class="view overlay card-image">
                            <img src="image/student.jpg" class="card-img-top" alt="">
                            <button @click="getListLecturers">
                                <div class="mask rgba-white-slight"></div>
                            </button>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">Số giảng viên hiện tại: {{lecturers}}</h4>
                            <button class="btn btn-primary btn-md" @click="getListLecturers">
                                <i class="fas fa-info-circle ml-2"></i> Xem danh sách
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="view overlay card-image">
                            <img src="image/project.jpg" class="card-img-top" alt="">
                            <button @click="getListProjects">
                                <div class="mask rgba-white-slight"></div>
                            </button>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">Số project hiện tại: {{projects}}</h4>
                            <button class="btn btn-primary btn-md" @click="getListProjects">
                                <i class="fas fa-info-circle ml-2"></i> Xem danh sách
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        name: "StudentMainComponent",
        created() {
            axios.get('/students/infoLaboratories')
                .then((res) => {
                    let data = res.data;
                    this.projects = data.projects;
                    this.lecturers = data.lecturers;
                }).catch((error) => {
                console.log(error);
            });
        },
        data() {
            return {
                lecturers: 0,
                projects: 0
            };
        },
        methods: {
            getListLecturers() {
                window.location.href = '/students/lecturers';
            },
            getListProjects() {
                window.location.href = '/students/projects';
            }
        }
    }
</script>

<style scoped>
    .card-image {
        height: 300px;
    }
</style>
