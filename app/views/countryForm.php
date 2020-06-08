<!DOCTYPE html PUBLIC>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="robots" content="noindex">
        <link rel="stylesheet" type="text/css" href="../app/style/main.css" media="screen" />
        <script type="text/javascript" src="../app/scripts/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="../app/scripts/main.js"></script>
	</head>
	<body>
		<div id="body">
			<div id="header">
				<h3 id="slogan">Country</a></h3>
			</div>
			<div id="content">
				<div id="contentMain">
                <ul id="pagePath">
                    <li><a href="index.php">Countries</a></li>
                </ul>
                    <div id="formContainer">
                        <?php if($data['formErrors'] != null) { ?>
                            <div class="errorBox">
                                The following fields were not entered or were entered incorrectly:
                                <?php 
                                    echo $data['formErrors'];
                                ?>
                            </div>
                        <?php } ?>
                        <?php
                         if(isset($data['sqlError']) && ($data['sqlError'] === false)) { ?>
                            <div class="errorBox">
                                This country is already added!
                            </div>
                        <?php } ?>
                        <form action="" method="post">
                            <fieldset>
                                <legend>Country information</legend>
                                <?php if(!isset($data['country']['id'])) { ?>
                                <p>
                                    <label class="field" for="name">Name<?php echo in_array('name', $data['required']) ? '<span> *</span>' : ''; ?></label>
                                    <input type="text" id="name" name="name" class="textbox textbox-150" value="<?php echo isset($data['country']['name']) ? $data['country']['name'] : ''; ?>">
                                    <?php if(key_exists('name', $data['maxLengths'])) echo "<span class='max-len'>(up to {$data['maxLengths']['name']} char.)</span>"; ?>
                                </p>
                                <?php } ?>
                                <p>
                                    <label class="field" for="area">Area (Km<sup style="font-size: 70%;vertical-align: super;">2</sup>)<?php echo in_array('area', $data['required']) ? '<span> *</span>' : ''; ?></label>
                                    <input type="text" id="area" name="area" class="textbox textbox-150" value="<?php echo isset($data['country']['area']) ? $data['country']['area'] : ''; ?>">
                                    <?php if(key_exists('area', $data['maxLengths'])) echo "<span class='max-len'>(up to {$data['maxLengths']['area']} char.)</span>"; ?>
                                </p>
                                <p>
                                    <label class="field" for="population">Population (Mill.)<?php echo in_array('population', $data['required']) ? '<span> *</span>' : ''; ?></label>
                                    <input type="text" id="population" name="population" class="textbox textbox-150" value="<?php echo isset($data['country']['population']) ? $data['country']['population'] : ''; ?>">
                                    <?php if(key_exists('population', $data['maxLengths'])) echo "<span class='max-len'>(up tp {$data['maxLengths']['population']} char.)</span>"; ?>
                                </p>
                            </fieldset>
                            <p class="required-note">* marked fields are required</p>
                            <p>
                                <input type="submit" class="submit button" name="submit" value="Save">
                            </p>
                            <?php if(isset($data['id'])) { ?>
                                <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
                            <?php } ?>
                        </form>
                    </div>
					<div class="float-clear"></div>
				</div>
			</div>
			<div id="footer">
			</div>
        </div>
	</body>
</html>
