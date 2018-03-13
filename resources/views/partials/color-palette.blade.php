{{-- 
Color Palette Partial

@param string varName

The Color Palette generates a simple color palette for the main form. It needs a
varname to generate the appropiate names for the inputs.

--}}
<div class="color-picker">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="row">
				<div class="col-xs-3">
					<label>
					  <input type="radio" name="color{{ $varName }}" value="Negro" />
					  <img src="{{ asset('img/suit_options/colores/negro.png') }}">
					  <p>Negro</p>
					</label>
				</div>
				<div class="col-xs-3">
					<label>
					  <input type="radio" name="color{{ $varName }}" value="Gris Oxford" />
					  <img src="{{ asset('img/suit_options/colores/gris_oxford.png') }}">
					  <p>Gris Oxford</p>
					</label>
				</div>
				<div class="col-xs-3">
					<label>
					  <input type="radio" name="color{{ $varName }}" value="Gris Claro" />
					  <img src="{{ asset('img/suit_options/colores/gris_claro.png') }}">
					  <p>Gris Claro</p>
					</label>
				</div>
				<div class="col-xs-3">
					<label>
					  <input type="radio" name="color{{ $varName }}" value="Blanco" />
					  <img src="{{ asset('img/suit_options/colores/blanco.png') }}">
					  <p>Blanco</p>
					</label>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-3">
					<label>
					  <input type="radio" name="color{{ $varName }}" value="Azul Marino" />
					  <img src="{{ asset('img/suit_options/colores/azul_marino.png') }}">
					  <p>Azul Marino</p>
					</label>
				</div>
				<div class="col-xs-3">
					<label>
					  <input type="radio" name="color{{ $varName }}" value="Azul Cielo" />
					  <img src="{{ asset('img/suit_options/colores/azul_cielo.png') }}">
					  <p>Azul Cielo</p>
					</label>
				</div>
				<div class="col-xs-3">
					<label>
					  <input type="radio" name="color{{ $varName }}" value="Rojo" />
					  <img src="{{ asset('img/suit_options/colores/rojo.png') }}">
					  <p>Rojo</p>
					</label>
				</div>
				<div class="col-xs-3">
					<label>
					  <input type="radio" name="color{{ $varName }}" value="Vino" />
					  <img src="{{ asset('img/suit_options/colores/vino.png') }}">
					  <p>Vino</p>
					</label>
				</div>
			</div>
		</div>
	</div>
	<div class="form-group label-floating">
		<label for="" class="control-label">Código de Otro Color <small>(Opcional)</small>:</label>
		<input type="text" name="otroColor{{ $varName }}" class="form-control">
	</div>
</div>