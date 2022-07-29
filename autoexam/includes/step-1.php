<fieldset class="form-box">
    <legend><span class="index">1</span> Select Institute</legend>
    <?php 
        $instituteQ = mysqli_query($connection, "SELECT * FROM institute ORDER BY institute_name");

        if(mysqli_num_rows($instituteQ) >= 1)
        {
            echo "<div class=\"radio-group-block\">";
                while ($instituteR = mysqli_fetch_assoc($instituteQ)) 
                {
                    if($institute_id == $instituteR['institute_id'])
                    {
                        echo "<div class=\"radio-group\">
                                <input type=\"radio\" name=\"institute\" id=\"ins$instituteR[institute_id]\" value=\"$instituteR[institute_id]\" onchange=\"showSTudyTypes(this.value)\" checked>
                                <label for=\"ins$instituteR[institute_id]\">$instituteR[institute_name]</label>
                            </div>";
                    }
                    else
                    {
                        echo "<div class=\"radio-group\">
                                <input type=\"radio\" name=\"institute\" id=\"ins$instituteR[institute_id]\" value=\"$instituteR[institute_id]\" onchange=\"showSTudyTypes(this.value)\">
                                <label for=\"ins$instituteR[institute_id]\">$instituteR[institute_name]</label>
                            </div>";
                    }
                   
                }
            echo "</div>";
        }
    ?>
</fieldset>

<fieldset class="form-box">

    <legend><span class="index">2</span> Select Study Type</legend>
    
    <div id="studyTypeResponse">
        <?php 
            if(isset($_GET['edit']))
            {
                
                $studyQ = mysqli_query($connection, "SELECT * FROM `type_of_study` WHERE institute_id = '$institute_id' ORDER BY `study_name`" );
                if(mysqli_num_rows($studyQ) >= 1 )
                {
                    while($studyRow = mysqli_fetch_assoc($studyQ))
                    {
                        if($studyId == $studyRow['type_of_study_id'])
                        {
                            echo "
                                <div class=\"radio-group\">
                                    <input type=\"radio\" name=\"study\" id=\"study$studyRow[type_of_study_id]\" value=\"$studyRow[type_of_study_id]\" onchange=\"showMajor(this.value)\" checked>
                                    <label for=\"study$studyRow[type_of_study_id]\">$studyRow[study_name]</label>
                                </div>";
                        }
                        else
                        {
                            echo "
                            <div class=\"radio-group\">
                                <input type=\"radio\" name=\"study\" id=\"study$studyRow[type_of_study_id]\" value=\"$studyRow[type_of_study_id]\" onchange=\"showMajor(this.value)\">
                                <label for=\"study$studyRow[type_of_study_id]\">$studyRow[study_name]</label>
                            </div>";
                        }
                    }
                }

            }
        ?>

    </div>

</fieldset>

<fieldset class="form-box">

    <legend><span class="index">3</span> Select Major</legend>

    <div id="majorResponse">
        <?php 
            if(isset($_GET['edit']))
            {
        ?>
                <select name="major" id="major" class="form-control">
                    <option value="">Select Major</option>
                    <?php 
                        $majorQ = mysqli_query($connection, "SELECT * FROM `major` WHERE type_of_study_id = '$studyId' ORDER BY `major_name`" );
                        if(mysqli_num_rows($majorQ) >= 1 )
                        {
                            while($majorRow = mysqli_fetch_assoc($majorQ))
                            {
                                if($majorId == $majorRow['major_id'])
                                {
                                    echo "<option value=\"$majorRow[major_id]\" selected>$majorRow[major_name]</option>";
                                }
                                else
                                {
                                    echo "<option value=\"$majorRow[major_id]\">$majorRow[major_name]</option>";
                                }
                            }
                        }
                    ?>
                </select>
        <?php 
            }
        ?>
    </div>

</fieldset>