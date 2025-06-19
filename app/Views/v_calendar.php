<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="<?= base_url('Home') ?>" class="headerButton goBack">
            <i class="fas fa-arrow-left fa-2x"></i>
        </a>
    </div>
    <div class="pageTitle"><?= $judul ?></div>
    <div class="right"></div>
</div>

<!-- * App Header -->
<div class="section full mt-2">
    <div class="section-title">Kalender</div>
    <div class="section-body">
        <div class="calendar-container">
            <div id="calendar"></div>
        </div>
    </div>
</div>
    <div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="<?= base_url('Home') ?>" class="headerButton goBack">
            <i class="fas fa-arrow-left fa-2x"></i>
        </a>
    </div>
    <div class="pageTitle"><?= $judul ?></div>
    <div class="right"></div>
</div>
    <div class="card-body">
        <div id="calendar"></div>
    <style>
        /* Basic page styling */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f9;
            margin: 0;
        }

        /* Calendar container */
        .calendar {
            width: 450px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Calendar header styling */
        .calendar-header {
            text-align: center;
            background-color: #007bff;
            color: white;
            padding: 10px;
            font-size: 1.2em;
            font-weight: bold;
        }

        /* Days of the week styling */
        .calendar-days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            background-color: #007bff;
            color: white;
        }

        .calendar-days div {
            padding: 10px;
            text-align: center;
            font-weight: bold;
        }

        /* Date cells styling */
        .calendar-dates {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
        }

        .calendar-dates div {
            padding: 20px;
            text-align: center;
            border: 1px solid #ddd;
        }

        /* Highlight today */
        .today {
            background-color: #ffdd57;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Calendar Container -->
    <div class="calendar">
        <!-- Month and Year Header -->
        <div class="calendar-header"><?= date('F Y') ?></div>

        <!-- Days of the Week -->
        <div class="calendar-days">
            <div>Sun</div>
            <div>Mon</div>
            <div>Tue</div>
            <div>Wed</div>
            <div>Thu</div>
            <div>Fri</div>
            <div>Sat</div>
        </div>

        <!-- Calendar Dates -->
        <div class="calendar-dates">
            <!-- Blank spaces for days before the month starts on Friday -->
            <div></div> <div></div> <div></div> <div></div> <div></div> <div class="today">1</div> <div>2</div> <div>3</div> <div>4</div> <div>5</div> <div>6</div> <div>7</div> <div>8</div> <div>9</div> <div>10</div> <div>11</div> <div>12</div> <div>13</div> <div>14</div> <div>15</div> <div>16</div> <div>17</div> <div>18</div> <div>19</div><div>20</div> <div>21</div> <div>22</div> <div>23</div> <div>24</div> <div>25</div> <div>26</div><div>27</div> <div>28</div> <div>29</div> <div>30</div> 
</body>
</html>
    </div>
    <div class="card-footer text-end">
        <button class="btn btn-primary" id="prevMonth" name="prevMonth">Bulan Sebelumnya</button>
        <button class="btn btn-primary" id="nextMonth" name="nextMonth">Bulan Berikutnya</button>
