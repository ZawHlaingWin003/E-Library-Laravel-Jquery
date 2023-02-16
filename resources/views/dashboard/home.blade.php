@extends('dashboard.layouts.app')

@section('title', 'Home Page')

@section('custom_style')
    <style>
        .chart{
            width: 100%;
            height: 400px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="card mb-4">
            <div class="card-header">
                <p class="m-0">Welcom To E-Library's Admin Dashboard</p>
                <h4>
                    <span class="text-primary">
                        {{ auth()->guard('admin_user')->user()->name }}({{ auth()->guard('admin_user')->user()->email }})
                    </span>
                </h4>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="card bg-success p-3">
                    <h2 class="mb-3">Total Reader</h2>
                    <div class="d-flex justify-content-between">
                        <h3><i class="fa fa-book-reader"></i></h3>
                        <h3>{{ $user_count }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-primary p-3">
                    <h2 class="mb-3">Total Books</h2>
                    <div class="d-flex justify-content-between">
                        <h3><i class="fa fa-book"></i></h3>
                        <h3>{{ $book_count }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning p-3">
                    <h2 class="mb-3">Total Authors</h2>
                    <div class="d-flex justify-content-between">
                        <h3><i class="fa fa-user-edit"></i></h3>
                        <h3>{{ $author_count }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-5 justify-content-center">
            <div class="col-md-5 mt-5">
                <div id="pie-chart" class="chart"></div>
            </div>
            <div class="col-md-7 my-3">
                <div id="bar-chart" class="chart"></div>
            </div>
        </div>
        <table class="table no-wrap">
            <thead>
                <tr>
                    <th class="border-top-0">#</th>
                    <th class="border-top-0">Name</th>
                    <th class="border-top-0">Email</th>
                    <th class="border-top-0">Phone</th>
                    <th class="border-top-0">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($admin_users as $admin_user)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td class="txt-oflo">{{ $admin_user->name }}</td>
                    <td>{{ $admin_user->email }}</td>
                    <td class="txt-oflo">{{ $admin_user->phone }}</td>
                    <td class="txt-oflo"><span class="badge bg-dark">Active</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $admin_users->links() }}
    </div>
@endsection

@section('custom_script')
    <script>

        // Defining function to get unique values from an array
        function getUnique(array){
            var uniqueArray = [];

            // Loop through array values
            for(i=0; i < array.length; i++){
                if(uniqueArray.indexOf(array[i]) === -1) {
                    uniqueArray.push(array[i]);
                }
            }
            return uniqueArray;
        }

        var pie_element = document.getElementById('pie-chart');
        var bar_element = document.getElementById('bar-chart');
        var categories = [];
        var prices = [];

        function getCategories(){
            /* $.ajax({
                url: 'https://fakestoreapi.com/products'
            }).done(function(data){
                $.each(data, function(key, value){
                    categories.push(value.category)
                    prices.push(value.price)
                })
                var uniqueCate = getUnique(categories);

                // console.log(categories, uniqueCate);
            }); */

            $.ajax({
                type: "GET",
                url: "https://fakestoreapi.com/products",
                data: {},
                dataType: "json",
                success: function (response) {
                    if(response){
                        $.each(response, function(key, value){
                            categories.push(value.category)
                            prices.push(value.price)
                        })

                        // var uniqueCate = getUnique(categories);
                        // console.log(categories, uniqueCate)
                    }
                },
                error: function(errMsg) {
                    alert('Error getting when fetch server data '+errMsg)
                }
            });
            return categories, prices;
            var uniqueCate = getUnique(categories);
            // console.log(categories, uniqueCate)
            // return uniqueCate;
        }

        $(document).ready(function(){
            var data = getCategories();
            console.log(data)
        })

        // console.log(categories)

        if (pie_element) {
            var pie_chart = echarts.init(pie_element);
            pie_chart.setOption({
                color: [
                    '#2ec7c9', '#b6a2de', '#5ab1ef', '#ffb980', '#d87a80',
                    '#8d98b3', '#e5cf0d', '#97b552', '#95706d', '#dc69aa',
                    '#07a2a4', '#9a7fd1', '#588dd5', '#f5994e', '#c05050',
                    '#59678c', '#c9ab00', '#7eb00a', '#6f5553', '#c14089'
                ],

                textStyle: {
                    fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                    fontSize: 13
                },

                title: {
                    text: 'Book Chart',
                    subtext: 'Fake Data From Factory',
                    left: 'center',

                    textStyle: {
                        fontSize: 20,
                        fontWeight: 700
                    },

                    subtextStyle: {
                        fontSize: 12
                    }
                },

                tooltip: {
                    trigger: 'item',
                    backgroundColor: 'rgba(0,0,0,0.75)',
                    padding: [10, 15],
                    textStyle: {
                        fontSize: 13,
                        fontFamily: 'Roboto, sans-serif'
                    },
                    formatter: "{a} <br/>{b}: {c} ({d}%)"
                },

                legend: {
                    orient: 'horizontal',
                    left: 'center',
                    bottom: 0,
                    itemHeight: 8,
                    itemWidth: 8
                },

                series: [{
                    name: 'Product Item',
                    type: 'pie',

                    radius: ['40%', '70%'],
                    itemStyle: {
                        borderRadius: 10,
                        borderColor: '#fff',
                        borderWidth: 2,
                    },

                    // radius: '70%',
                    // center: ['50%', '50%'],
                    // itemStyle: {
                    //     normal: {
                    //         borderWidth: 1,
                    //         borderColor: '#fff'
                    //     }
                    // },

                    // label: {
                    //     show: false,
                    //     position: 'center'
                    // },
                    // emphasis: {
                    //     label: {
                    //         show: true,
                    //         fontSize: '35',
                    //         fontWeight: 'bold'
                    //     }
                    // },
                    // labelLine: {
                    //     show: false
                    // },

                    data: [{
                            value: 63,
                            name: 'Laptop'
                        },
                        {
                            value: 45,
                            name: 'Desktop'
                        },
                        {
                            value: 58,
                            name: 'Phone'
                        },
                        {
                            value: 61,
                            name: 'Tablet'
                        },
                    ]
                }]
            });
        }


        if (bar_element) {
            var bar_chart = echarts.init(bar_element);
            bar_chart.setOption({
                xAxis: {
                    type: 'category',
                    data: ['Mon', 'Tue', 'Wed', 'Thur', 'Fri']
                },
                yAxis: {
                    type: 'value'
                },
                series: [{
                    data: [23, 34, 55, 30, 45],
                    type: 'bar',
                    showBackground: true,
                    backgroundStyle: {
                        color: 'rgba(180, 180, 180, 0.2)'
                    }
                }]
            })
        }
    </script>
@endsection
