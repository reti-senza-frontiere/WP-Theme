<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title><?php echo get_bloginfo('name'); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>

<body style="margin:0;background:#efefef;font-family:Arial, Helvetica, sans-serif;color:#333;font-size:13px;">
<div style="width:600px;margin:0 auto;background:#fff;box-shadow:0 0 15px #ccc;">
    <div style="padding:20px 30px;">
        <div>
            <header style="border-bottom:1px solid #ccc;padding:0 0 10px 0;">
                <h1 style="margin:0;padding:0;font-size:30px;font-weight:normal;"><?php echo get_bloginfo('name'); ?></h1>
            </header>
            <div>
                <p><?php echo __("E' stato compilato il form.", 'rsf'); ?></p>
                <p>
                    <?php echo __('Nome', 'rsf')?>: <?php echo $data['first_name']; ?><br />
                    <?php echo __('Cognome', 'rsf')?>: <?php echo $data['last_name']; ?><br />
                    <?php echo __('E-Mail', 'rsf')?>: <?php echo $data['email']; ?><br />
                    <?php echo __('Oggetto', 'rsf')?>: <?php echo $data['subject']; ?><br />
                    <?php echo __('Messaggio', 'rsf')?>: <?php echo $data['msg']; ?><br />
                </p>
            </div>
        </div>
        <div style="margin:20px 0 0 0;">
            <p style="font-size:9px;color:#999;"><?php echo __(sprintf('This message is confidential. It may also be privileged or otherwise protected by work product immunity or other legal rules. If you have received it by mistake please let us know by reply and then delete it from your system; you should not copy the message or disclose its contents to anyone. All messages sent to and from %s may be monitored to censure compliance with internal policies and to protect our business.', get_bloginfo('name')), 'rsf'); ?></p>
        </div>
    </div>
</div>
</body>

</html>
