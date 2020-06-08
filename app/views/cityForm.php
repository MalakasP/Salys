<!DOCTYPE html PUBLIC>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="robots" content="noindex">
        <link rel="stylesheet" type="text/css" href="../app/style/main.css" media="screen" />
        <script type="text/javascript" src="../app/scripts/jquery-2.1.1.min.js"></script>
	</head>
	<body>
		<div id="body">
			<div id="header">
				<h3 id="slogan">City</a></h3>
			</div>
			<div id="content">
				<div id="contentMain">
                <ul id="pagePath">
                    <li><a href="index.php">Countries</a></li>
                    <li><a href='index.php?module=<?php echo $data['module'] ?>&action=index&country=<?php echo $data['country'] ?>'><?php echo $data['country'] ?></a></li>
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
                                This city is already added!
                            </div>
                        <?php } ?>
                        <form action="" method="post">
                            <fieldset>
                                <legend>City information</legend>
                                <p>
                                    <label class="field" for="name">Name<?php echo in_array('name', $data['required']) ? '<span> *</span>' : ''; ?></label>
                                    <input type="text" id="name" name="name" class="textbox textbox-150" value="<?php echo isset($data['city']['name']) ? $data['city']['name'] : ''; ?>">
                                    <?php if(key_exists('name', $data['maxLengths'])) echo "<span class='max-len'>(up to {$data['maxLengths']['name']} char.)</span>"; ?>
                                </p>
                                <p>
                                    <label class="field" for="area">Area (Km<sup style="font-size: 70%;vertical-align: super;">2</sup>)<?php echo in_array('area', $data['required']) ? '<span> *</span>' : ''; ?></label>
                                    <input type="text" id="area" name="area" class="textbox textbox-150" value="<?php echo isset($data['city']['area']) ? $data['city']['area'] : ''; ?>">
                                    <?php if(key_exists('area', $data['maxLengths'])) echo "<span class='max-len'>(up to {$data['maxLengths']['area']} char.)</span>"; ?>
                                </p>
                                <p>
                                    <label class="field" for="population">Population<?php echo in_array('population', $data['required']) ? '<span> *</span>' : ''; ?></label>
                                    <input type="text" id="population" name="population" class="textbox textbox-150" value="<?php echo isset($data['city']['population']) ? $data['city']['population'] : ''; ?>">
                                    <?php if(key_exists('population', $data['maxLengths'])) echo "<span class='max-len'>(up to {$data['maxLengths']['population']} char.)</span>"; ?>
                                </p>
                                <p>
                                    <label class="field" for="postal_code">Postal code<?php echo in_array('postal_code', $data['required']) ? '<span> *</span>' : ''; ?></label>
                                    <input type="text" id="postal_code" name="postal_code" class="textbox textbox-150" value="<?php echo isset($data['city']['postal_code']) ? $data['city']['postal_code'] : ''; ?>">
                                    <?php if(key_exists('postal_code', $data['maxLengths'])) echo "<span class='max-len'>(up to {$data['maxLengths']['postal_code']} char.)</span>"; ?>
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
