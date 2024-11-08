<div class="container">
    <h1>Fetching Data</h1>
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        Google Sheet Data
                    </h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <?php 
                                                foreach($values[0] as $headings){  
                                                    echo "<th>".$headings."</th>";
                                                }
                                            ?>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                                            for($i = 1; $i<count($values); $i++){
                                                ?>
                            <tr>
                                <?php
                                                        foreach($values[$i] as $data){
                                                            echo "<td>".$data."</td>";
                                                        }
                                                    ?>
                            </tr>
                            <?php
                                            }
                                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>