<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fleet Management | API-Con</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .train-card {
            border: none;
            border-radius: 20px;
            transition: all 0.3s ease;
            background: #ffffff;
        }

        .train-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
        }

        .search-bar {
            border-radius: 50px;
            padding-left: 25px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        }

        .search-bar:focus {
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            border-color: #3b82f6;
        }

        /* Custom Badge Styles */
        .badge-premium {
            background: #eff6ff;
            color: #1e40af;
        }

        .badge-business {
            background: #fef2f2;
            color: #991b1b;
        }

        .badge-economy {
            background: #f0fdf4;
            color: #166534;
        }

        [v-cloak] {
            display: none;
        }
    </style>
</head>

<body>

    <div id="app" class="container py-5" v-cloak>
        <div class="row mb-5 align-items-center">
            <div class="col-lg-4 mb-3 mb-lg-0">
                <h2 class="fw-800 text-dark mb-0">Train Fleet</h2>
                <p class="text-muted mb-3">Manage and track live routes</p>
                <button class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addTrainModal">
                    + Add New Train
                </button>
            </div>

            <div class="col-lg-5 mb-3 mb-lg-0">
                <div class="input-group">
                    <input type="text" v-model="searchQuery" class="form-control form-control-lg search-bar"
                        placeholder="Search train name..." @input="debounceSearch">

                    <select v-model="selectedClass" class="form-select form-select-lg border-start-0"
                        style="max-width: 150px; border-radius: 0 50px 50px 0;" @change="fetchTrains(1)">
                        <option value="">All Class</option>
                        <option value="economy">Economy</option>
                        <option value="business">Business</option>
                        <option value="premium">Premium</option>
                    </select>
                </div>
            </div>

            <div class="col-lg-3 text-lg-end">
                <button @click="fetchTrains(1)" class="btn btn-light border rounded-pill px-4 fw-bold">
                    <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
                    Sync Data
                </button>
            </div>
        </div>

        @verbatim
        <div class="row g-4">
            <div v-if="loading && trains.length === 0" class="col-12 text-center py-5">
                <div class="spinner-grow text-primary" role="status"></div>
            </div>

            <div v-if="trains.length === 0 && !loading" class="col-12 text-center py-5">
                <div class="p-5 bg-white rounded-4 shadow-sm border border-dashed">
                    <h4 class="text-muted">No trains found</h4>
                    <p class="mb-0">Try adjusting your search criteria or add a new train.</p>
                </div>
            </div>

            <div v-for="train in trains" :key="train.id" class="col-12 col-md-6 col-lg-4">
                <div class="card train-card h-100 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <h5 class="fw-bold text-dark mb-1">{{ train.name }}</h5>
                                <span class="text-muted small">#ID-{{ train.id }}</span>
                            </div>
                            <span :class="['badge rounded-pill px-3 py-2 text-uppercase fw-bold', 'badge-' + train.class]">
                                {{ train.class }}
                            </span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <div class="d-flex gap-2">
                                <button @click="openEditModal(train)" class="btn btn-link text-primary p-0 border-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                    </svg>
                                </button>

                                <button @click="deleteTrain(train.id)" class="btn btn-link text-danger p-0 border-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                        <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                    </svg>
                                </button>
                            </div>

                            <a :href="'/detail/' + train.id" class="btn btn-outline-primary btn-sm rounded-pill px-4 fw-bold">
                                Live Map
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <nav v-if="totalPages > 1" class="mt-5 d-flex justify-content-center">
            <ul class="pagination shadow-sm p-1 bg-white rounded-pill">
                <li class="page-item" :class="{ disabled: currentPage === 1 }">
                    <a class="page-link border-0 rounded-circle mx-1" href="#" @click.prevent="fetchTrains(currentPage - 1)">&laquo;</a>
                </li>
                <li v-for="page in totalPages" :key="page" class="page-item" :class="{ active: currentPage === page }">
                    <a class="page-link border-0 rounded-circle mx-1" href="#" @click.prevent="fetchTrains(page)">{{ page }}</a>
                </li>
                <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                    <a class="page-link border-0 rounded-circle mx-1" href="#" @click.prevent="fetchTrains(currentPage + 1)">&raquo;</a>
                </li>
            </ul>
        </nav>

        <div class="modal fade" id="addTrainModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 rounded-4 shadow">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="fw-bold">{{ isEditing ? 'Edit Train' : 'Add New Train' }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" @click="resetForm"></button>
                    </div>
                    <form @submit.prevent="submitTrain">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Train Name</label>
                                <input v-model="form.name" type="text" class="form-control rounded-3" placeholder="e.g. Argo Parahyangan" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Service Class</label>
                                <select v-model="form.class" class="form-select rounded-3" required>
                                    <option value="economy">Economy</option>
                                    <option value="business">Business</option>
                                    <option value="premium">Premium</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer border-0 pt-0">
                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal" id="closeModalBtn">Cancel</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold" :disabled="isSubmitting">
                                <span v-if="isSubmitting" class="spinner-border spinner-border-sm me-1"></span>
                                {{ isEditing ? 'Edit Fleet' : 'Create Fleet' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endverbatim

    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const {
            createApp,
            ref,
            onMounted
        } = Vue

        createApp({
            setup() {
                const trains = ref([])
                const loading = ref(false)
                const isSubmitting = ref(false)
                const searchQuery = ref('')
                const selectedClass = ref('')
                const currentPage = ref(1)
                const totalPages = ref(1)
                const form = ref({
                    name: '',
                    class: 'economy'
                })
                const isEditing = ref(false);
                const selectedTrainId = ref(null);
                let searchTimer = null

                const fetchTrains = async (page = 1) => {
                    loading.value = true
                    try {
                        const response = await axios.get('/api/train', {
                            params: {
                                page: page,
                                search: searchQuery.value,
                                class: selectedClass.value
                            }
                        })
                        trains.value = response.data.data
                        currentPage.value = response.data.current_page
                        totalPages.value = response.data.last_page
                    } catch (error) {
                        console.error("Fetch Error:", error)
                    } finally {
                        loading.value = false
                    }
                }

                const debounceSearch = () => {
                    clearTimeout(searchTimer)
                    searchTimer = setTimeout(() => fetchTrains(1), 500)
                }

                const openEditModal = (train) => {
                    isEditing.value = true;
                    selectedTrainId.value = train.id;
                    form.value = {
                        name: train.name,
                        class: train.class
                    };
                    // Manually trigger the Bootstrap modal
                    new bootstrap.Modal(document.getElementById('addTrainModal')).show();
                };

                const submitTrain = async () => {
                    isSubmitting.value = true
                    try {
                        const url = isEditing.value ?
                            `/api/train/${selectedTrainId.value}` :
                            '/api/trains';

                        const method = isEditing.value ? 'put' : 'post';

                        const response = await axios({
                            method: method,
                            url: url,
                            data: form.value,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });



                        // Use the data returned from your Laravel controller
                        const newTrain = response.data.data

                        // Add to the top of the list manually
                        trains.value.unshift(newTrain)

                        // Remove the last item if you want to keep the pagination count exact
                        if (trains.value.length > 6) trains.value.pop()

                        form.value = {
                            name: '',
                            class: 'economy'
                        }
                        document.getElementById('closeModalBtn').click()
                        await fetchTrains(currentPage.value);

                        resetForm();
                    } catch (error) {
                        if (error.response && error.response.status === 422) {
                            // Get the validation errors from Laravel
                            const errors = error.response.data.errors;
                            const message = Object.values(errors).flat().join('\n');
                            alert("Validation Failed:\n" + message);
                        } else {
                            alert('Something went wrong. Check console.');
                        }
                    } finally {
                        isSubmitting.value = false
                    }
                }

                const deleteTrain = async (id) => {
                    if (!confirm('Are you sure you want to remove this train from the fleet?')) {
                        return;
                    }

                    try {
                        await axios.delete(`/api/train/${id}`, {
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });

                        // Refresh the current page to update the list
                        await fetchTrains(currentPage.value);

                        alert('Train removed.');
                    } catch (error) {
                        console.error("Delete Error:", error);
                        alert('Failed to delete the train.');
                    }
                }

                const resetForm = () => {
                    isEditing.value = false;
                    selectedTrainId.value = null;
                    form.value = {
                        name: '',
                        class: 'economy'
                    };
                };

                const formatDate = (dateStr) => {
                    if (!dateStr) return '-'
                    return new Date(dateStr).toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'short',
                        year: 'numeric'
                    })
                }

                onMounted(fetchTrains)

                return {
                    trains,
                    loading,
                    searchQuery,
                    currentPage,
                    totalPages,
                    trains,
                    loading,
                    searchQuery,
                    currentPage,
                    totalPages,
                    form,
                    isSubmitting,
                    isEditing,
                    openEditModal,
                    resetForm,
                    submitTrain,
                    deleteTrain,
                    fetchTrains,
                    debounceSearch,
                    selectedClass,
                    formatDate
                }
            }
        }).mount('#app')
    </script>
</body>

</html>