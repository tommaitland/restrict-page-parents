<div class="wrap">

    <?php screen_icon(); ?>
    
    <h2>Restrict Page Parents</h2>
    
    <form method="post" action="options.php">
    
    	<?php settings_fields('rpp_plugin_options'); ?>
    	<?php $options = get_option('rpp_options'); ?>
    	    	
    	<div id="poststuff">
    	
    		<div id="post-body" class="metabox-holder columns-2">
    		
    			
    			<!-- main content -->
    			<div id="post-body-content">
    				
    				<div class="meta-box">
    					
    					<h2>Role Permissions</h2>
    					
    					<table class="widefat">
    						<thead>
    							<tr>
    								<th class="row-title" width="40%">Role Name</th>
    								<th>Page Parent Restrictions</th>
                                    <th>Force Page Parent</th>
    							</tr>
    						</thead>
    						<tbody>
    						    							
    							<?php 
								    // get all available roles
								    
								    global $wp_roles;
								
								    $roles = $wp_roles->roles;
									
									$i = 0;							    
								    foreach ($roles as $role) : 
								    	if (isset($role['capabilities']['edit_pages']) && $role['capabilities']['edit_pages'] == 1) :
								?>
    						
	    							<tr <?php if ($i%2) echo 'class="alt"'; ?>>
	    								<td class="row-title"><?php echo $role['name']; ?></td>
	    								<td>
	    								
	    									<fieldset>

                                                <select name="rpp_options[enable_restrictions-<?php echo strtolower($role['name']); ?>]" id="rpp_options[enable_restrictions-<?php echo strtolower($role['name']); ?>]">

                                                    <option value="0" <?php selected('0', $options['enable_restrictions-' . strtolower($role['name'])]); ?>>Disable</option>
                                                    <option value="1" <?php selected('1', $options['enable_restrictions-' . strtolower($role['name'])]); ?>>Enable</option>

                                                </select>
	    										
	    									</fieldset>
	    									
	    								</td>

                                        <td>
                                        
                                            <fieldset>

                                                <select name="rpp_options[force_parent-<?php echo strtolower($role['name']); ?>]" id="rpp_options[force_parent-<?php echo strtolower($role['name']); ?>]">

                                                    <option value="0" <?php selected('0', $options['force_parent-' . strtolower($role['name'])]); ?>>Disable</option>
                                                    <option value="1" <?php selected('1', $options['force_parent-' . strtolower($role['name'])]); ?>>Enable</option>

                                                </select>
                                                
                                            </fieldset>
                                            
                                        </td>

	    							</tr>
    							
    							<?php $i++; endif; endforeach; ?>
    							
    						</tbody>
    					</table>
    					
    					<h2>User Permissions</h2>
    					
    					<p>Permissions set for an individual user will override any role permissions set.</p>
    					
    					<table class="widefat">
    						<thead>
    							<tr>
    								<th>Override?</th>
                                    <th class="row-title" width="25%">Role Name</th>
    								<th>Page Parent Restrictions</th>
                                    <th>Force Page Parent</th>
    							</tr>
    						</thead>
    						<tbody>
    						    							
    							<?php 
								    // get all available users
								    
								    $users = get_users();
								    								    																								    
								    $i = 0;
								    foreach ($users as $user) : 
								    	if (isset($user->allcaps['edit_pages']) && $user->allcaps['edit_pages'] == 1) :
								?>
    						
	    							<tr <?php if ($i%2) echo 'class="alt"'; ?>>
	    								<td>
                                            <input name="rpp_options[override-<?php echo $user->user_login; ?>]"
                                                type="checkbox"
                                                value="1"
                                                <?php if (isset($options['override-' . $user->user_login])) { checked('1', $options['override-' . $user->user_login]); } ?>
                                            />
                                        </td>
                                        <td class="row-title"><?php echo $user->user_login ?></td>
	    								<td>
	    								
	    									<fieldset>

                                                <select name="rpp_options[enable_restrictions-<?php echo $user->user_login; ?>]" id="rpp_options[enable_restrictions-<?php echo $user->user_login; ?>]">

                                                    <option value="0" <?php selected('0', $options['enable_restrictions-' . $user->user_login]); ?>>Disable</option>
                                                    <option value="1" <?php selected('1', $options['enable_restrictions-' . $user->user_login]); ?>>Enable</option>

                                                </select>
	    										
	    									</fieldset>
	    									
	    								</td>
                                        <td>
                                        
                                            <fieldset>

                                                <select name="rpp_options[force_parent-<?php echo $user->user_login; ?>]" id="rpp_options[force_parent-<?php echo $user->user_login; ?>]">

                                                    <option value="0" <?php selected('0', $options['force_parent-' . $user->user_login]); ?>>Disable</option>
                                                    <option value="1" <?php selected('1', $options['force_parent-' . $user->user_login]); ?>>Enable</option>

                                                </select>
                                                
                                            </fieldset>
                                            
                                        </td>
	    							</tr>
    							
    							<?php $i++; endif; endforeach; ?>
    							
    						</tbody>
    					</table>
    					
    				</div><!-- .meta-box -->
    				
    			</div><!-- post-body-content -->
    			

    			<!-- sidebar -->
    			<div id="postbox-container-1" class="postbox-container">
    				<div class="meta-box" style="margin-top:66px">
    					
    					<div class="postbox">
    					
    						<h3><span>About Restrict Page Parents</span></h3>
    						<div class="inside">
    							<p>Restrict Page Parents prevents the set user roles or users from setting a page parent that isn't owned by them. It can also force these users to set a page parent.</p>
    							<p><em>NOTE: Only roles and users with the ability to edit pages will show here.</em></p>
    							<p>It's designed to enhance WordPress websites that have multiple editors, creating finer control over content management.</p>
    							<p>The plugin is built by <a href="http://www.tommaitland.net/" target="_blank">Tom Maitland</a>, the code lives on <a href="#">GitHub</a>.</p>
    						</div>
    					
    					</div><!-- .postbox -->
    					
    				</div><!-- .meta-box -->
    			</div><!-- #postbox-container-1 .postbox-container -->
    			
    		</div><!-- #post-body .metabox-holder .columns-2 -->
    		
    		<br class="clear">
    		
    	</div><!-- #poststuff -->
    	
    	<input class="button-primary" type="submit" name="Example" value="<?php _e( 'Save Changes' ); ?>" />
    
    </form>
			
</div> <!-- .wrap -->