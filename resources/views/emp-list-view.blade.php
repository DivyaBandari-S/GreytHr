<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@5.x.x/dist/alpine.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @livewireStyles
</head>

<body>
    @livewire('emp-list')
    @livewireScripts
</body>
<style>
                .empTable {

border-collapse: collapse;

background-color: white;
border: 1px solid #e2e8f0;
font-size: 12px;
margin-left: 10px;
}

.empTable td {
border: 1px solid #e2e8f0;
padding: 0.75rem;
text-align: left;
}

.empTable th {
border: 1px solid #e2e8f0;
padding: 0.75rem;
text-align: center;
background-color: #02134F;
color: #f0f4f8;
font-weight: bold;
white-space: nowrap;
}

.empTable tbody tr:hover {
background-color: #f0f4f8;
}
table,thead,tbody{
width: 100%;
}
.whitespace-nowrap{
text-transform: capitalize;
text-align: center;
}
.whitespace-nowrappp{
 width:150px;
 text-align: center;

}
.logout {
background-color: rgb(2, 17, 79);
/* Coral color */
color: #fff;
border: none;
padding: 10px 15px;
margin-top: 5px;
cursor: pointer;
transition: background-color 0.3s ease;
border: 1px solid white;
border-radius: 5px;
font-size: 12px;
}

.logout:hover {
background-color: #fff;
color: black
/* Darker coral color on hover */
}
</style>
</html>