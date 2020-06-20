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
                            <button @click="getListStudents">
                                <div class="mask rgba-white-slight"></div>
                            </button>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">Số sinh viên hiện tại: </h4>
                            <button class="btn btn-primary btn-md">
                                <i class="fas fa-info-circle ml-2"></i> Xem danh sách
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="view overlay card-image">
                            <img src="image/project-type.png" class="card-img-top">
                            <a href="#">
                                <div class="mask rgba-white-slight"></div>
                            </a>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">Số đề tài hiện tại: </h4>
                            <button class="btn btn-primary btn-md">
                                <i class="fas fa-info-circle ml-2"></i> Xem danh sách
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="view overlay card-image">
                            <img src="image/project.jpg" class="card-img-top" alt="">
                            <a href="https://mdbootstrap.com/vue/" target="_blank">
                                <div class="mask rgba-white-slight"></div>
                            </a>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">Số project hiện tại: </h4>
                            <button class="btn btn-primary btn-md">
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
        name: "LaboratoryMainComponent",
        created() {
            axios.get('/lecturers/infoLaboratories')
                .then(() => {
                }).catch((error) => {
                console.log(error);
            });
        },
        data() {
            return {}
        },
    }
</script>

<style scoped>
    .card-image {
        height: 300px;
    }
</style>
