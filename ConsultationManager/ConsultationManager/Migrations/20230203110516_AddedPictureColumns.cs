using Microsoft.EntityFrameworkCore.Migrations;

#nullable disable

namespace ConsultationManager.Migrations
{
    /// <inheritdoc />
    public partial class AddedPictureColumns : Migration
    {
        /// <inheritdoc />
        protected override void Up(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.AddColumn<string>(
                name: "Picture",
                table: "Patients",
                type: "nvarchar(max)",
                nullable: false,
                defaultValue: "");

            migrationBuilder.AddColumn<string>(
                name: "Picture",
                table: "Doctors",
                type: "nvarchar(max)",
                nullable: false,
                defaultValue: "");
        }

        /// <inheritdoc />
        protected override void Down(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropColumn(
                name: "Picture",
                table: "Patients");

            migrationBuilder.DropColumn(
                name: "Picture",
                table: "Doctors");
        }
    }
}
