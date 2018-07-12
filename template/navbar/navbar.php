<div class="navbar-fixed">
	<nav class="color-1">
		<div class="nav-wrapper">
			<a href="#" data-activates="mobile-nav" class="button-collapse">
				<i class="material-icons">menu</i>
			</a>

			<a href="dashboard" class="brand-logo">
				<img src="image/brg_logo.png">
			</a>

			<ul class="right hide-on-med-and-down">
				<?php if (!$auth->check()) : ?>
					<li>
						<a href="login">Login</a>
					</li>
				<?php else : ?>
					<li>
						<a href="dashboard">Dashboard</a>
					</li>

					<li>
						<a class="dropdown-button" data-activates="systems-dropdown">
							BRG-Systeme<i class="material-icons right">arrow_drop_down</i>
						</a>

						<ul id="systems-dropdown" class="dropdown-content color-3 z-depth-2">
							<li>
								<a href="dashboard/request">Requests</a>
							</li>

							<li>
								<a href="dashboard/message">Nachrichten</a>
							</li>
						</ul>
					</li>

					<li>
						<a href="dashboard/history">History</a>
					</li>

					<li>
						<a href="dashboard/vote">Votes</a>
					</li>

					<li>
						<a href="dashboard/donation">Spenden</a>
					</li>

					<li>
						<a class="dropdown-button" data-activates="statistics-dropdown">
							Statistik<i class="material-icons right">arrow_drop_down</i>
						</a>

						<ul id="statistics-dropdown" class="dropdown-content color-3 z-depth-2">
							<li>
								<a href="dashboard/statistic/request">Requests</a>
							</li>

							<li>
								<a href="dashboard/statistic/request/artist">Requests pro Artist</a>
							</li>

							<li>
								<a href="dashboard/statistic/request/title">Requests pro Title</a>
							</li>

							<li>
								<a href="dashboard/statistic/request/user">Requests pro User</a>
							</li>
						</ul>
					</li>

					<li>
						<a href="dashboard/account">
							<i class="material-icons">account_circle</i>
						</a>
					</li>

					<li>
						<a href="logout">
							<i class="material-icons">exit_to_app</i>
						</a>
					</li>
				<?php endif; ?>
			</ul>

			<ul class="side-nav color-1" id="mobile-nav">
				<?php if (!$auth->check()) : ?>
					<li>
						<a href="login">Login</a>
					</li>
				<?php else : ?>
					<li>
						<a href="dashboard">Dashboard</a>
					</li>

					<li>
						<a href="dashboard/request">Requests</a>
					</li>

					<li>
						<a href="dashboard/message">Nachrichten</a>
					</li>

					<li>
						<a href="dashboard/history">History</a>
					</li>

					<li>
						<a href="dashboard/vote">Votes</a>
					</li>

					<li>
						<a href="dashboard/donation">Spenden</a>
					</li>

					<li>
						<a href="dashboard/statistic/request">Statistik | Requests</a>
					</li>

					<li>
						<a href="dashboard/statistic/request/artist">Statistik | Requests pro Artist</a>
					</li>

					<li>
						<a href="dashboard/statistic/request/title">Statistik | Requests pro Title</a>
					</li>

					<li>
						<a href="dashboard/statistic/request/user">Statistik | Requests pro User</a>
					</li>

					<li>
						<a href="dashboard/account">
							<i class="material-icons">account_circle</i>Benutzer
						</a>
					</li>

					<li>
						<a href="logout">
							<i class="material-icons">exit_to_app</i>Ausloggen
						</a>
					</li>
				<?php endif; ?>
			</ul>
		</div>
	</nav>
</div>
