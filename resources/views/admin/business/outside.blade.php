@extends('layouts.admin')

@section('content')
<!--左侧导航结束-->
<div class="content-wrapper">
    <el-row id="config">
        <el-breadcrumb separator="/">
            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item>欢迎!</el-breadcrumb-item>
        </el-breadcrumb>
 
        <el-form :model="searchForm" :rules="searchRules" ref="searchForm" label-width="150px"
                         inline="true" action="{{ url('admin/business/outside') }}"  method="GET" id="searchForm">
            <input type="hidden" name="year" id="year-text" :value="searchForm.year">
            <input type="hidden" name="month" id="month-text" :value="searchForm.month">
            <input type="hidden" name="appList" id="appList-text" :value="searchForm.appList">
            <input type="hidden" name="sourceList" id="sourceList-text" :value="searchForm.sourceList">
            <el-form-item label="年份" prop="year">
                <el-select v-model="searchForm.year" placeholder="请选择">
                    <el-option
                            v-for="item in searchYearList"
                            :key="item.value"
                            :label="item.label"
                            :value="item.label">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="月份" prop="month">
                <el-select v-model="searchForm.month" placeholder="请选择">
                    <el-option
                            v-for="item in searchMonthList"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="应用列表" prop="appList">
                <el-select v-model="searchForm.appList"  placeholder="请选择" filterable>
                    <el-option
                            v-for="item in searchApp"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="渠道列表" prop="sourceList">
                <el-select v-model="searchForm.sourceList"  placeholder="请选择" filterable>
                    <el-option
                            v-for="item in searchSource"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                    </el-option>
                </el-select>
            </el-form-item>
            
            <el-form-item>
                <el-button type="primary" @click="submitForm('searchForm')">查询</el-button>
                <el-button @click="resetForm('searchForm')">重置</el-button>
            </el-form-item>

        </el-form>

        <el-table id="table" :data="tableData" border height="500" style="width: 100%">
            <el-table-column
                    label="日期"
                    width="180">
                <template scope="scope">
                    <span style="margin-left: 10px">@{{ scope.row.day }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    label="新增用户"
                    width="180">
                <template scope="scope">
                    <div class="name-wrapper">
                    @{{scope.row.newUser }}
                    </div>
                </template>
            </el-table-column>
            <el-table-column label="新增设备数" width="180">
                <template scope="scope">
                    @{{ scope.row.newUUID }}
                </template>
            </el-table-column>
            <el-table-column label="新增活跃数" width="180">
                <template scope="scope">
                    @{{ scope.row.activeUser }}
                </template>
            </el-table-column>
            <el-table-column label="活跃设备数" width="180">
                <template scope="scope">
                    @{{ scope.row.activeUUID }}
                </template>
            </el-table-column>
            <el-table-column label="充值总额" width="180">
                <template scope="scope">
                    @{{ scope.row.totalAmount }}
                </template>

            </el-table-column>
            <!-- <el-table-column label="操作" width="180">
                <template scope="scope">
                    <a href="edit.html" class="icon-operate"><i class="el-icon-edit text-success "></i></a>
                    <i class="el-icon-delete text-info  icon-operate" @click="deleteItem"></i>
                </template>
            </el-table-column> -->
        </el-table>

    </el-row>
</div>

<script type="text/javascript">
    var index = new Vue({
        el: '#index',
        data: {
            order_index : '{{ $bkAdminUri }}',
            searchApp:  [@if (isset($appSource['app']))
                            @foreach ($appSource['app'] as $item)
                            {
                                value: {{ $item['value'] }},
                                label: '{{ $item['label'] }}' 
                            },
                            @endforeach
                        @endif],
            searchSource: [@if (isset($appSource['source']))
                            @foreach ($appSource['source'] as $value)
                            {
                                value: '{{ $value['value'] }}',
                                label: '{{ $value['label'] }}' 
                            },
                            @endforeach
                        @endif],
            searchYearList: [{
                value: 2018,
                label: '2018'
            }, {
                value: 2017,
                label: '2017'
            }, {
                value: 2016,
                label: '2016'
            }, {
                value: 2015,
                label: '2015'
            }],
            searchMonthList: [{
                value: 1,
                label: '1'
            }, {
                value: 2,
                label: '2'
            }, {
                value: 3,
                label: '3'
            }, {
                value: 4,
                label: '4'
            }, {
                value: 5,
                label: '5'
            }, {
                value: 6,
                label: '6'
            }, {
                value: 7,
                label: '7'
            }, {
                value: 8,
                label: '8'
            }, {
                value: 9,
                label: '9'
            }, {
                value: 10,
                label: '10'
            }, {
                value: 11,
                label: '11'
            }, {
                value: 12,
                label: '12'
            }],
            searchForm: {
                year: @if (isset($search['year'])) {{ $search['year'] }} @else '' @endif,
                month: @if (isset($search['month'])) {{ $search['month'] }} @else '' @endif,
                appList: @if (isset($search['appId'])) {{ $search['appId'] }} @else '' @endif,
                sourceList: @if (isset($search['sourceId'])) {!! $search['sourceId'] !!} @else '' @endif,
            },
            searchRules: {
                // year: [
                //     {required: true, message: '请选择应用'}
                // ],
                // month: [
                //     {required: true, message: '请选择应用组'}
                // ],
                // appList: [
                //     {required: true, message: '请选择渠道'}
                // ],
                // sourceList: [
                //     {required: true, message: '请选择开始时间'}
                // ]
            },
            tableData: [
                @if (isset($outside))
                    @foreach ($outside as $business)
                    {
                        day: '{{ $business['day'] }}',
                        newUser: '{{ $business['newUser'] }}',
                        newUUID: '{{ $business['newUUID'] }}',
                        activeUser: '{{ $business['activeUser'] }}',
                        activeUUID: '{{ $business['activeUUID'] }}',
                        totalAmount: '{{ $business['totalAmount'] }}',
                    },
                    @endforeach
                @endif
            ],
        },
        methods: {
            submitForm: function (formName,confirm) {
                var _this = this;
                this.$refs[formName].validate(function (valid) {
                    if (valid) {
                        var form = document.getElementById(formName); //this.submit();
                        //console.log(document.getElementsByName('year').value); //this.submit();
                        form.submit();
                    }
                });
            },
            resetForm: function (formName) {
                this.$refs[formName].resetFields();
            },
            deleteItem:function () {
                var _this = this;
                _this.$confirm('确认删除吗？', '提示', {type: 'warning'})
                    .then(function () {
                    _this.$message({
                        type:'success',
                        message:'删除成功'
                    })
                    })
                    .catch(function () {
                        _this.$message({
                            type:'info',
                            message:'已取消删除成功'
                        })
                    });
            }
        }
    });



</script>
@endsection

