<div id="systems" class="card color-2 white-text">
	<div class="card-content">
		<div class="card-title center">BRG Systeme</div>
		<div class="divider"></div>
	</div>
	<div class="card-tabs">
		<ul class="tabs tabs-fixed-width color-1">
			<li class="tab">
				<a href="#system-requests">Requests</a>
			</li>
			<li class="tab">
				<a href="#system-messages">Nachrichten</a>
			</li>
			<li class="tab">
				<a href="#system-autodj-requests">AutoDJ-Requests</a>
			</li>
		</ul>
	</div>
	<div class="card-content">
		<div id="system-requests">
			<table class="bordered">
				<tbody>
					<tr>
						<th>Status</th>
						<td>
							<?php if ($system['request']['active']) : ?>
								<span>Aktiv</span>
							<?php else : ?>
								<span>Inaktiv</span>
							<?php endif; ?>
						</td>
						<td>
							<?php if ($system['request']['active']) : ?>
								<a href="#!" id="set-request-system-active" class="red-text tooltipped" data-position="top" data-delay="50" data-tooltip="deaktivieren" data-active="0">
									<i class="material-icons">remove_circle</i>
								</a>
							<?php else : ?>
								<a href="#!" id="set-request-system-active" class="green-text tooltipped" data-position="top" data-delay="50" data-tooltip="Aktivieren" data-active="1">
									<i class="material-icons">check_circle</i>
								</a>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<th>Requests&nbsp;pro&nbsp;Person</th>
						<td>
							<span><?php echo $system['request']['limit']; ?></span>
						</td>
						<td>
							<a href="#!" id="set-request-system-requests-count" class="tooltipped" data-position="top" data-delay="50" data-tooltip="Anzahl ändern">
								<i class="material-icons">input</i>
							</a>
						</td>
					</tr>
					<tr>
						<th>Aktive&nbsp;Requests</th>
						<td>
							<span><?php echo $system['request']['requests']; ?></span>
						</td>
						<td></td>
					</tr>
					<tr>
						<th>Regeln</th>
						<td>
							<span><?php echo $system['request']['rules']; ?></span>
						</td>
						<td>
							<a href="#!" class="set-system-rules tooltipped" data-system-id="<?php echo $system['request']['id']; ?>" data-position="top" data-delay="50" data-tooltip="Regeln ändern">
								<i class="material-icons">input</i>
							</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div id="system-messages">
			<table class="bordered">
				<tbody>
					<tr>
						<th>Status</th>
						<td>
							<?php if ($system['message']['active']) : ?>
								<span>Aktiv</span>
							<?php else : ?>
								<span>Inaktiv</span>
							<?php endif; ?>
						</td>
						<td>
							<?php if ($system['message']['active']) : ?>
								<a href="#!" id="set-message-system-active" class="red-text tooltipped" data-position="top" data-delay="50" data-tooltip="deaktivieren" data-active="0">
									<i class="material-icons">remove_circle</i>
								</a>
							<?php else : ?>
								<a href="#!" id="set-message-system-active" class="green-text tooltipped" data-position="top" data-delay="50" data-tooltip="Aktivieren" data-active="1">
									<i class="material-icons">check_circle</i>
								</a>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<th>Vorhandene&nbsp;Nachrichten</th>
						<td>
							<span><?php echo $system['message']['messages']; ?></span>
						</td>
						<td></td>
					</tr>
					<tr>
						<th>Regeln</th>
						<td>
							<span><?php echo $system['message']['rules']; ?></span>
						</td>
						<td>
							<a href="#!" class="set-system-rules tooltipped" data-system-id="<?php echo $system['message']['id']; ?>" data-position="top" data-delay="50" data-tooltip="Regeln ändern">
								<i class="material-icons">input</i>
							</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div id="system-autodj-requests">
			<table class="bordered">
				<tbody>
					<tr>
						<th>Status</th>
						<td>
							<?php if ($system['autodj_request']['active']) : ?>
								<span>Aktiv</span>
							<?php else : ?>
								<span>Inaktiv</span>
							<?php endif; ?>
						</td>
						<td>
							<?php if ($system['autodj_request']['active']) : ?>
								<a href="#!" id="set-autodj-request-system-active" class="red-text tooltipped" data-position="top" data-delay="50" data-tooltip="deaktivieren" data-active="0">
									<i class="material-icons">remove_circle</i>
								</a>
							<?php else : ?>
								<a href="#!" id="set-autodj-request-system-active" class="green-text tooltipped" data-position="top" data-delay="50" data-tooltip="Aktivieren" data-active="1">
									<i class="material-icons">check_circle</i>
								</a>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<th>Requests&nbsp;pro&nbsp;Person</th>
						<td>
							<span><?php echo $system['autodj_request']['limit']; ?></span>
						</td>
						<td></td>
					</tr>
					<tr>
						<th>Aktive&nbsp;Requests</th>
						<td>
							<span><?php echo $system['autodj_request']['requests']; ?></span>
						</td>
						<td></td>
					</tr>
					<tr>
						<th>Regeln</th>
						<td>
							<span><?php echo $system['autodj_request']['rules']; ?></span>
						</td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
