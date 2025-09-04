import Chart from 'chart.js/auto';



const ctx = document.getElementById('myChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['A', 'B', 'C'],
        datasets: [{
            label: 'Example Data',
            data: [5, 10, 3],
            backgroundColor: ['#f00', '#0f0', '#00f']
        }]
    }
});
        
function baseURL(){
    return location.protocol + "//" + location.host + "";
}

$('#patientTable').DataTable({
    ajax: baseURL() + '/patients/list',
    processing: true,
    serverSide: true,
    columnDefs: [
        { targets: '_all', visible: true }
    ],
    columns: [
        {
            data:'patient_id',
            name: 'patient_id',
            title: 'ID',
        },
        {
            data:'last_name',
            name: 'last_name',
            title: 'Last Name',
        },
        {
            data:'first_name',
            name: 'first_name',
            title: 'First Name',
        },
        {
            data:'middle_initial',
            name: 'middle_initial',
            title: 'Middle Initial',
        },
        // {
        //     data:'date_of_birth',
        //     name: 'date_of_birth',
        //     title: 'Date of Birth',
        // },
        {
            data:'gender',
            name: 'gender',
            title: 'Gender',
        }
    ]
});
function openModal() {
    document.getElementById('patientModal').classList.remove('hidden');
    window.history.pushState({}, '', '/students/add-student');
}

function closeModal() {
    document.getElementById('patientModal').classList.add('hidden');
    window.history.pushState({}, '', '/students');
}

window.addEventListener('popstate', function () {
    const modal = document.getElementById('patientModal');
    if (window.location.pathname === '/students') {
        modal.classList.add('hidden');
    } else if (window.location.pathname === '/students/add-student') {
        modal.classList.remove('hidden');
    }
});